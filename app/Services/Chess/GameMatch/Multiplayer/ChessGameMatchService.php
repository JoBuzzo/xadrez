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
        $userColor = $this->room->user['color'];
        $turn = $this->room->user['turn'];
        $board = $this->room->board;

        $myTurn = $turn && (Piece::pieceAndUserIsWhite($piece, $userColor) || Piece::pieceAndUserIsBlack($piece, $userColor));

        if ($this->canSelectPiece && $myTurn) {
            $this->selectedPiece = SelectedPieceDTO::fromSquareClick($position, $piece);

            $this->possibilities = MatchPiecesService::matchPieces($board, $position, $piece);

            // TODO: Debugar se o movimento especial do peão "passant" está funcionando
            if ($this->passant) {
                $this->possibilities[] = $this->passant;
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
     * é chamado quando o jogador movimenta uma peça
     *
     * @param array $data
     * @return void
     */
    public function handleMovedPiece(array $data): void
    {
        $this->room->board = $data['board'];
        $this->whiteKingIsInCheck = MatchPiecesService::checkWhiteKing($this->room->board);
        $this->blackKingIsInCheck = MatchPiecesService::checkBlackKing($this->room->board);

        $this->room->turn = $data['from'] != $this->room->user['color'] && !$this->promotionModal ? $this->room->oponnent['color'] : $this->room->user['color'];
        $this->room->user['check'] = $this->userIsWhite() ? $this->whiteKingIsInCheck : $this->blackKingIsInCheck;
        $this->room->oponnent['check'] = $this->userIsWhite() ? $this->blackKingIsInCheck : $this->whiteKingIsInCheck;
        $this->room->user['promotion'] = $this->promotionModal;
        $this->room->user['replacePosition'] = $this->replacePosition;

        $room = [
            'uuid' => $this->room->uuid,
            'board' => $this->room->board,
            'turn' => $this->room->turn,
            'users' => [$this->room->user, $this->room->oponnent]
        ];

        Cache::put('game-match-' . $room['uuid'], $room);
    }
}
