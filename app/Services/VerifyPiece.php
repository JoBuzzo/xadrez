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
                return self::possibleMovesKing($board, $position, $piece);

            default:
                return [];
        }
    }

    private static function possibleMovesKing($board, $position, $piece)
    {
        $possibilities = King::possibleMoves($board, $position, $piece);

        foreach ($board as $key => $b) {
            if ($b != $piece) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                    case ChessPiece::PAWN_BLACK:
                        $possibilitiesPawn = Pawn::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesPawn);
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                    case ChessPiece::ROOK_BLACK:
                        $possibilitiesRook = Rook::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesRook);
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                    case ChessPiece::KNIGHT_BLACK:
                        $possibilitiesKnight = Knight::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesKnight);
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                    case ChessPiece::BISHOP_BLACK:
                        $possibilitiesBishop = Bishop::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesBishop);
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                    case ChessPiece::QUEEN_BLACK:
                        $possibilitiesQueen = Queen::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesQueen);
                        }
                        break;
                }
            }
        }

        return $possibilities;
    }
}
