<?php

namespace App\Services;

use App\Enums\ChessPiece;

class VerifyPiece
{
    public static function verify(array $board, $position, $piece)
    {
        switch ($piece) {
            case ChessPiece::PAWN_WHITE:
            case ChessPiece::PAWN_BLACK:
                return Pawn::possibleMoves($board, $position, $piece);

            case ChessPiece::ROOK_WHITE:
            case ChessPiece::ROOK_BLACK:
                return Rook::possibleMoves($board, $position, $piece);

            case ChessPiece::KNIGHT_WHITE:
            case ChessPiece::KNIGHT_BLACK:
                return Knight::possibleMoves($board, $position, $piece);

            case ChessPiece::BISHOP_WHITE:
            case ChessPiece::BISHOP_BLACK:
                return Bishop::possibleMoves($board, $position, $piece);

            case ChessPiece::QUEEN_WHITE:
            case ChessPiece::QUEEN_BLACK:
                return Queen::possibleMoves($board, $position, $piece);

            case ChessPiece::KING_WHITE:
            case ChessPiece::KING_BLACK:
                return King::possibleMoves($board, $position, $piece);

            default:
                return [];
        }
    }
}
