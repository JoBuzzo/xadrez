<?php

namespace App\Services\Chess\GameMatch\Multiplayer\Traits;

use App\Enums\ChessPiece;
use App\Services\Chess\GameMatch\MatchPiecesService;
use App\Services\Chess\Piece\Piece;

trait History
{
    public function handleHistory(string $targetPosition): void
    {
        $pieceLetter = match ($this->selectedPiece->piece) {
            ChessPiece::PAWN_WHITE, ChessPiece::PAWN_BLACK => '',
            ChessPiece::ROOK_WHITE,  ChessPiece::ROOK_BLACK  => 'R',
            ChessPiece::KNIGHT_WHITE,ChessPiece::KNIGHT_BLACK=> 'N',
            ChessPiece::BISHOP_WHITE,ChessPiece::BISHOP_BLACK=> 'B',
            ChessPiece::QUEEN_WHITE, ChessPiece::QUEEN_BLACK => 'Q',
            ChessPiece::KING_WHITE,  ChessPiece::KING_BLACK  => 'K',
        };

        $isCapture = Piece::pieceIsBlackOrWhite($this->room->board[$targetPosition]);

        if ($isCapture) {
            $this->room->user->capturedPieces[] = $this->room->board[$targetPosition];

            if ($pieceLetter === '') {
                $col = preg_replace('/[0-9]/', '', $this->selectedPiece->position);
                $notation = $col . 'x' . $targetPosition;
            } else {
                $disamb = $this->checkIfHasAmbiguity($targetPosition);
                $notation = $pieceLetter . $disamb . 'x' . $targetPosition;
            }
        } else {
            if ($pieceLetter === '') {
                $notation = $targetPosition;
            } else {
                $disamb = $this->checkIfHasAmbiguity($targetPosition);
                $notation = $pieceLetter . $disamb . $targetPosition;
            }
        }

        $this->room->history[] = $notation;
        $this->reloadRoomOnCache();
    }

    private function checkIfHasAmbiguity(string $targetPosition): string
    {
        $conflictingPieces = [];

        foreach ($this->room->board as $pos => $occupant) {
            if ($this->selectedPiece->piece == $occupant && $pos != $this->selectedPiece->position) {
                $possibilities = MatchPiecesService::matchPieces(
                    $this->room->board,
                    $pos,
                    $occupant
                );

                if (in_array($targetPosition, $possibilities)) {
                    $conflictingPieces[] = $pos;
                }
            }
        }

        if (empty($conflictingPieces)) {
            return '';
        }

        $col = preg_replace('/[0-9]/', '', $this->selectedPiece->position);
        $row = preg_replace('/[a-h]/', '', $this->selectedPiece->position);

        foreach ($conflictingPieces as $conflict) {
            $conflictCol = preg_replace('/[0-9]/', '', $conflict);
            $conflictRow = preg_replace('/[a-h]/', '', $conflict);

            if ($conflictCol !== $col) {
                return $col;
            } elseif ($conflictRow !== $row) {
                return $row;
            }
        }

        return '';
    }
}
