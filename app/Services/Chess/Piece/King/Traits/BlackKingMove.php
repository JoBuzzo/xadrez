<?php

namespace App\Services\Chess\Piece\King\Traits;

use App\Enums\ChessPiece;
use App\Enums\ChessPieceColor;

trait BlackKingMove
{
    /**
     * Summary of getBlackKingSmallerRoque
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function getBlackKingSmallerRoque(array $board, string $position, string $piece): array
    {
        if (
            $position == 'e8' && ChessPiece::getColor($piece) == ChessPieceColor::BLACK
            && $board['h8'] == parent::$pieces['blacks'][0]
        ) {
            if ($board['f8'] == 'f8' && $board['g8'] == 'g8') {
                return ['g8'];
            }
        }

        return [];
    }

    /**
     * Summary of getBlackKingBiggerRoque
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function getBlackKingBiggerRoque(array $board, string $position, string $piece): array
    {
        if (
            $position == 'e8' && ChessPiece::getColor($piece) == ChessPieceColor::BLACK
            && $board['a8'] == parent::$pieces['blacks'][0]
        ) {
            if ($board['b8'] == 'b8' && $board['c8'] == 'c8' && $board['d8'] == 'd8') {
                return ['c8'];
            }
        }

        return [];
    }
}
