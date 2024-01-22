<?php

namespace App\Services;

use App\Enums\ChessPiece;

class Check
{
    public static function verify(array $board, $position, $piece): bool
    {
        $positionKingBlack = array_search(ChessPiece::KING_BLACK, $board);
        $positionKingWhite = array_search(ChessPiece::KING_WHITE, $board);

        switch ($piece) {
            case ChessPiece::PAWN_WHITE:
            case ChessPiece::PAWN_BLACK:
                $possibilities = Pawn::possibleMoves($board, $position, $piece);

                if (in_array($positionKingBlack, $possibilities)) {
                    return true;
                }
                if (in_array($positionKingWhite, $possibilities)) {
                    return true;
                }
                return false;

            case ChessPiece::ROOK_WHITE:
            case ChessPiece::ROOK_BLACK:
                $possibilities =  Rook::possibleMoves($board, $position, $piece);

                if (in_array($positionKingBlack, $possibilities)) {
                    return true;
                }
                if (in_array($positionKingWhite, $possibilities)) {
                    return true;
                }
                return false;

            case ChessPiece::KNIGHT_WHITE:
            case ChessPiece::KNIGHT_BLACK:
                $possibilities =  Knight::possibleMoves($board, $position, $piece);

                if (in_array($positionKingBlack, $possibilities)) {
                    return true;
                }
                if (in_array($positionKingWhite, $possibilities)) {
                    return true;
                }
                return false;

            case ChessPiece::BISHOP_WHITE:
            case ChessPiece::BISHOP_BLACK:
                $possibilities =  Bishop::possibleMoves($board, $position, $piece);

                if (in_array($positionKingBlack, $possibilities)) {
                    return true;
                }
                if (in_array($positionKingWhite, $possibilities)) {
                    return true;
                }
                return false;

            case ChessPiece::QUEEN_WHITE:
            case ChessPiece::QUEEN_BLACK:
                $possibilities =  Queen::possibleMoves($board, $position, $piece);

                if (in_array($positionKingBlack, $possibilities)) {
                    return true;
                }
                if (in_array($positionKingWhite, $possibilities)) {
                    return true;
                }
                return false;
            default:
                return false;
        }
    }
}
