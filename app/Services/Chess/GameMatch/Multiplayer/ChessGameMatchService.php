<?php

namespace App\Services\Chess\GameMatch\Multiplayer;

use App\Events\MovedPiece;
use App\Services\Chess\GameMatch\MatchPiecesService;
use App\Services\Chess\GameMatch\Multiplayer\DTO\SelectedPieceDTO;
use App\Services\Chess\GameMatch\Multiplayer\Traits\ChessGameMatch;
use App\Services\Chess\Piece\Piece;
use Illuminate\Support\Facades\Cache;

class ChessGameMatchService
{
    use ChessGameMatch;

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
        $board = $this->room->board;

        $myTurn = $turn && (Piece::pieceAndUserIsWhite($piece, $userColor) || Piece::pieceAndUserIsBlack($piece, $userColor));

        if ($this->canSelectPiece && $myTurn) {
            $this->selectedPiece = SelectedPieceDTO::fromSquareClick($position, $piece);

            $this->possibilities = MatchPiecesService::matchPieces($board, $position, $piece);

            // TODO: Debugar se o movimento especial do peão "passant" está funcionando
            if ($this->room->user->passant) {
                $this->possibilities[] = $this->room->user->passant;
            }

            $this->removeCastlingIfInCheck($piece, $position);
            $this->revokeCastlingRights($piece, $position);
            $this->canSelectPiece = false;
        } else if ($turn) {
            if ($this->existsPositionInPossibilities($position)) {
                $board[$this->selectedPiece->position] = $this->selectedPiece->position;
                $board[$position] = $this->selectedPiece->piece;
                $this->markCastlingPiecesMoved();
                $this->executeCastlingMove($position);
                $this->handleEnPassantCapture($position);
                $this->handlePawnPromotion($position);
                event(new MovedPiece($board, $userColor, $this->room->uuid));
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

        $this->room->turn = $data['from'] != $this->room->user->uuid && !$this->room->user->promotion ? $this->room->oponnent->uuid : $this->room->user->uuid;
        $this->room->user->check = $this->userIsWhite() ? $whiteKingIsInCheck : $blackKingIsInCheck;
        $this->room->oponnent->check = $this->userIsWhite() ? $blackKingIsInCheck : $whiteKingIsInCheck;

        $room = [
            'uuid' => $this->room->uuid,
            'board' => $this->room->board,
            'turn' => $this->room->turn,
            'users' => [$this->room->user->toArray(), $this->room->oponnent->toArray()]
        ];

        Cache::put('game-match-' . $room['uuid'], $room);
    }
}
