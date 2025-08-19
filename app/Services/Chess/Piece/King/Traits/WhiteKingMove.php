<?php

namespace App\Services\Chess\Piece\King\Traits;

use App\Enums\ChessPiece;
use App\Enums\ChessPieceColor;

trait WhiteKingMove
{
    /**
     * Summary of getWhiteKingSmallerRoque
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function getWhiteKingSmallerRoque(array $board, string $position, string $piece): array
    {
        if (
            $position == 'e1' && ChessPiece::getColor($piece) == ChessPieceColor::WHITE
            && $board['h1'] == parent::$pieces['whites'][0]
        ) {
            if ($board['f1'] == 'f1' && $board['g1'] == 'g1') {
                return ['g1'];
            }
        }

        return [];
    }

    /**
     * Summary of getWhiteKingBiggerRoque
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function getWhiteKingBiggerRoque(array $board, string $position, string $piece): array
    {
        if (
            $position == 'e1' && ChessPiece::getColor($piece) == ChessPieceColor::WHITE
            && $board['a1'] == parent::$pieces['whites'][0]
        ) {
            if ($board['b1'] == 'b1' && $board['c1'] == 'c1' && $board['d1'] == 'd1') {
                return ['c1'];
            }
        }

        return [];
    }
}
