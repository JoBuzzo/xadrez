<?php

namespace App\Services\Chess\Piece\Bishop;

use App\Services\Chess\Piece\Bishop\Traits\BishopMoves;
use App\Services\Chess\Piece\Piece;

class BishopService extends Piece
{
    use BishopMoves;
    /**
     * Summary of possibleMoves
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $indexOfAbc = array_search($letter, parent::$abc);

        return array_merge(
            self::getBishopUpperRightMoves($board, $number, $indexOfAbc, $piece),
            self::getBishopUpperLeftMoves($board, $number, $indexOfAbc, $piece),
            self::getBishopLowerRightMoves($board, $number, $indexOfAbc, $piece),
            self::getBishopLowerLeftMoves($board, $number, $indexOfAbc, $piece),
        );
    }
}
