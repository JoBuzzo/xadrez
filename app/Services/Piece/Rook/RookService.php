<?php

namespace App\Services\Piece\Rook;

use App\Services\Piece\Piece;
use App\Services\Piece\Rook\Traits\BlackRookMoves;
use App\Services\Piece\Rook\Traits\WhiteRookMoves;

class RookService extends Piece
{
    use WhiteRookMoves;
    use BlackRookMoves;

    /**
     * Summary of possibleMoves
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return array
     */
    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = parent::getLetterAndNumber($position);

        $possibilities = [];

        $indexOfAbc = array_search($letter, parent::$abc);

        if (parent::pieceIsWhite($piece)) {
            $possibilities = array_merge(
                $possibilities,
                self::getWhiteRookRightMoves($board, $number, $indexOfAbc),
                self::getWhiteRookLeftMoves($board, $number, $indexOfAbc),
                self::getWhiteRookLowerMoves($board, $number, $letter),
                self::getWhiteRookUpperMoves($board, $number, $letter),
            );

        }else if(parent::pieceIsBlack($piece)) {
            $possibilities = array_merge(
                $possibilities,
                self::getBlackRookRightMoves($board, $number, $indexOfAbc),
                self::getBlackRookLeftMoves($board, $number, $indexOfAbc),
                self::getBlackRookLowerMoves($board, $number, $letter),
                self::getBlackRookUpperMoves($board, $number, $letter),
            );
        }

        return $possibilities;
    }
}
