<?php

namespace App\Services;

use App\Enums\ChessPiece;

class Check
{
    public static function verify(array $board): bool
    {
        $positionKingBlack = array_search(ChessPiece::KING_BLACK, $board);
        $positionKingWhite = array_search(ChessPiece::KING_WHITE, $board);

        $return = false;

        foreach ($board as $key => $b) {
            if ($b != $key) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                    case ChessPiece::PAWN_BLACK:
                        $possibilities = Pawn::possibleMoves($board, $key, $b);
                        if (in_array($positionKingBlack, $possibilities) || in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                    case ChessPiece::ROOK_BLACK:
                        $possibilities = Rook::possibleMoves($board, $key, $b);
                        if (in_array($positionKingBlack, $possibilities) || in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                    case ChessPiece::KNIGHT_BLACK:
                        $possibilities = Knight::possibleMoves($board, $key, $b);
                        if (in_array($positionKingBlack, $possibilities) || in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                    case ChessPiece::BISHOP_BLACK:
                        $possibilities = Bishop::possibleMoves($board, $key, $b);
                        if (in_array($positionKingBlack, $possibilities) || in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                    case ChessPiece::QUEEN_BLACK:
                        $possibilities = Queen::possibleMoves($board, $key, $b);
                        if (in_array($positionKingBlack, $possibilities) || in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                }
            }
        }

        return $return;
    }
}
