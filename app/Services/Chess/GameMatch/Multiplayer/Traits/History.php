<?php

namespace App\Services\Chess\GameMatch\Multiplayer\Traits;

use App\Enums\ChessPiece;
use App\Services\Chess\Piece\Piece;

trait History
{
    public function handleHistory(string $position)
    {
        $letter = match ($this->selectedPiece->piece) {
            ChessPiece::PAWN_WHITE, ChessPiece::PAWN_BLACK => '',
            ChessPiece::ROOK_WHITE, ChessPiece::ROOK_BLACK => 'R',
            ChessPiece::KNIGHT_WHITE, ChessPiece::KNIGHT_BLACK => 'N',
            ChessPiece::BISHOP_WHITE, ChessPiece::BISHOP_BLACK => 'B',
            ChessPiece::QUEEN_WHITE, ChessPiece::QUEEN_BLACK => 'Q',
            ChessPiece::KING_WHITE, ChessPiece::KING_BLACK => 'K',
        };

        $letter .= $this->captured($position);

        $letter .= $position;

        $this->room->history[] = $letter;

        $this->reloadRoomOnCache();
    }

    private function captured(string $position): string
    {
        if (Piece::pieceIsBlackOrWhite($this->room->board[$position])) {
            $this->room->user->capturedPieces[] = $this->room->board[$position];
            if($this->selectedPiece->piece == ChessPiece::PAWN_WHITE || $this->selectedPiece->piece ==ChessPiece::PAWN_BLACK){
                $column = preg_replace('/[0-9]/', '', $this->selectedPiece->position);
                $column .= 'x';
                return $column;
            }

            return 'x';
        }
        return '';
    }
}
