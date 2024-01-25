<?php

namespace App\Services;

use App\Enums\ChessPiece;
use App\Enums\ChessPieceColor;

class EscapeCheck
{
    public static function verify(array $board, $position, $piece)
    {
        if (ChessPiece::getColor($piece) == ChessPieceColor::WHITE) {
            $kingPosition = array_search(ChessPiece::KING_WHITE, $board);
        }
        if (ChessPiece::getColor($piece) == ChessPieceColor::BLACK) {
            $kingPosition = array_search(ChessPiece::KING_BLACK, $board);
        }

        foreach ($board as $key => $b) {
            if ($key != $b && ChessPiece::getColor($b) != ChessPiece::getColor($piece)) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                    case ChessPiece::PAWN_BLACK:
                        $possibilities = Pawn::possibleMoves($board, $key, $b);
                        if (in_array($kingPosition, $possibilities)) {
                            $piecesWithCheck[] = [
                                'position' => $key,
                                'piece' => $b,
                            ];
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                    case ChessPiece::ROOK_BLACK:
                        $possibilities = Rook::possibleMoves($board, $key, $b);
                        if (in_array($kingPosition, $possibilities)) {
                            $piecesWithCheck[] = [
                                'position' => $key,
                                'piece' => $b,
                            ];
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                    case ChessPiece::KNIGHT_BLACK:
                        $possibilities = Knight::possibleMoves($board, $key, $b);
                        if (in_array($kingPosition, $possibilities)) {
                            $piecesWithCheck[] = [
                                'position' => $key,
                                'piece' => $b,
                            ];
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                    case ChessPiece::BISHOP_BLACK:
                        $possibilities = Bishop::possibleMoves($board, $key, $b);
                        if (in_array($kingPosition, $possibilities)) {
                            $piecesWithCheck[] = [
                                'position' => $key,
                                'piece' => $b,
                            ];
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                    case ChessPiece::QUEEN_BLACK:
                        $possibilities = Queen::possibleMoves($board, $key, $b);
                        if (in_array($kingPosition, $possibilities)) {
                            $piecesWithCheck[] = [
                                'position' => $key,
                                'piece' => $b,
                            ];
                        }
                        break;
                }
            }
        }

        $possibilities = VerifyPiece::verify($board,  $position, $piece);

        foreach ($piecesWithCheck as $pCheck) {

           $arr = array_intersect($possibilities, $pCheck);
        }

        dump($arr);
        return $possibilities;
    }
}
