<?php

namespace App\Services\Chess\GameMatch\Multiplayer;

use App\Services\Chess\GameMatch\Multiplayer\Traits\ChessGameMatch;
use App\Services\Chess\GameMatch\Multiplayer\DTO\SelectedPieceDTO;
use App\Services\Chess\GameMatch\Multiplayer\DTO\RoomDTO;
use App\Services\Chess\GameMatch\MatchPiecesService;
use Illuminate\Support\Facades\Cache;
use App\Services\Chess\Piece\Piece;
use App\Events\MovedPiece;

class ChessGameMatchService
{
    use ChessGameMatch;

    public function __construct(
        string $roomUuid,
        string $userUuid,
        bool $canSelectPiece = true,
        array $selectedPiece = [],
        array $possibilities = []
    ) {
        $this->room = RoomDTO::fromCache($roomUuid, $userUuid);

        $this->notifySecondPlayerJoined();

        $this->canSelectPiece = $canSelectPiece;

        if ($selectedPiece) {
            $this->selectedPiece = SelectedPieceDTO::fromSquareClick($selectedPiece['position'], $selectedPiece['piece']);
        }

        $this->possibilities = $possibilities;
    }

    /**
     * Summary of handleSquareClick
     * @param string $position
     * @param string $piece
     * @return void
     */
    public function handleSquareClick(string $position, string $piece): void
    {
        $userColor = $this->room->user->color;
        $turn = $this->room->user->turn;

        $myTurn = $turn && (Piece::pieceAndUserIsWhite($piece, $userColor) || Piece::pieceAndUserIsBlack($piece, $userColor));

        if ($this->canSelectPiece && $myTurn) {
            $this->selectedPiece = SelectedPieceDTO::fromSquareClick($position, $piece);

            $this->possibilities = MatchPiecesService::matchPieces($this->room->board, $position, $piece);

            // TODO: Debugar se o movimento especial do peão "passant" está funcionando
            if ($this->room->user->passant) {
                $this->possibilities[] = $this->room->user->passant;
            }

            $this->removeCastlingIfInCheck($piece, $position);
            $this->revokeCastlingRights($piece, $position);
            $this->canSelectPiece = false;
        } else if ($turn) {
            if ($this->existsPositionInPossibilities($position)) {
                $this->room->board[$this->selectedPiece->position] = $this->selectedPiece->position;
                $this->room->board[$position] = $this->selectedPiece->piece;
                $this->markCastlingPiecesMoved();
                $this->executeCastlingMove($position);
                $this->handleEnPassantCapture($position);
                $this->handlePawnPromotion($position);
                event(new MovedPiece($this->room->board, $this->room->user->uuid, $this->room->uuid));
            }

            $this->selectedPiece = null;
            $this->possibilities = [];
            $this->canSelectPiece = true;
        }
    }

    /**
     * handleMovedPiece
     * é chamado quando o jogador movimenta uma peça (método que vai chamar assim que ouvir um evento)
     *
     * @param array $data
     * @return void
     */
    public function handleMovedPiece(array $data): void
    {
        $this->room->board = $data['board'];
        $whiteKingIsInCheck = MatchPiecesService::checkWhiteKing($this->room->board);
        $blackKingIsInCheck = MatchPiecesService::checkBlackKing($this->room->board);

        $playedByUser = $data['from'] === $this->room->user->uuid;
        $this->room->user->turn = ! $playedByUser;
        $this->room->opponent->turn = $playedByUser;

        $this->room->turn = $playedByUser ? $this->room->opponent->uuid : $this->room->user->uuid;

        $this->room->user->check = $this->userIsWhite() ? $whiteKingIsInCheck : $blackKingIsInCheck;
        $this->room->opponent->check = $this->userIsWhite() ? $blackKingIsInCheck : $whiteKingIsInCheck;

        $room = [
            'uuid' => $this->room->uuid,
            'board' => $this->room->board,
            'turn' => $this->room->turn,
            'users' => [$this->room->user->toArray(), $this->room->opponent->toArray()]
        ];

        Cache::put('game-match-' . $room['uuid'], $room);
    }

    /**
     * Summary of getRoom
     * @return array
     */
    public function getRoom(): array
    {
        return $this->room->toArray();
    }

    /**
     * Summary of getBoard
     * @return array
     */
    public function getBoard(): array
    {
        return $this->room->board;
    }

    /**
     * Summary of getUser
     * @return array
     */
    public function getUser(): array
    {
        return $this->room->user->toArray();
    }

    /**
     * Summary of getOpponent
     * @return array
     */
    public function getOpponent(): array
    {
        if (!$this->room->opponent) {
            return [];
        }

        return $this->room->opponent->toArray();
    }

    /**
     * Summary of getSelectedPiece
     * @return array
     */
    public function getSelectedPiece(): array
    {
        if (!$this->selectedPiece) {
            return [];
        }

        return $this->selectedPiece->toArray();
    }

    public function getCanSelectPiece(): bool
    {
        return $this->canSelectPiece;
    }

    /**
     * Summary of getPossibilities
     * @return array
     */
    public function getPossibilities(): array
    {
        return $this->possibilities;
    }
}
