<?php

namespace App\Services\Chess\Piece\Queen;

use App\Services\Chess\Piece\Piece;
use App\Services\Chess\Piece\Queen\Traits\BlackQueenMoves;
use App\Services\Chess\Piece\Queen\Traits\QueenMoves;
use App\Services\Chess\Piece\Queen\Traits\WhiteQueenMoves;

class QueenService extends Piece
{
    use QueenMoves;
    use WhiteQueenMoves;
    use BlackQueenMoves;

    /**
     * Summary of possibleMoves
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return array
     */
    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = self::getLetterAndNumber($position);
        $indexOfAbc = array_search($letter, parent::$abc);

        $possibilidades = array_merge(
            self::getQueenUpperRightMoves($board, $number, $indexOfAbc, $piece),
            self::getQueenUpperLeftMoves($board, $number, $indexOfAbc, $piece),
            self::getQueenLowerRightMoves($board, $number, $indexOfAbc, $piece),
            self::getQueenLowerLeftMoves($board, $number, $indexOfAbc, $piece),
        );

        if (parent::pieceIsWhite($piece)) {
            $possibilidades = array_merge(
                $possibilidades,
                self::getWhiteQueenRightMoves($board, $number, $indexOfAbc),
                self::getWhiteQueenLeftMoves($board, $number, $indexOfAbc),
                self::getWhiteQueenLowerMoves($board, $number, $letter),
                self::getWhiteQueenUpperMoves($board, $number, $letter),
            );
        }else if(parent::pieceIsBlack($piece)) {
            $possibilidades = array_merge(
                $possibilidades,
                self::getBlackQueenRightMoves($board, $number, $indexOfAbc),
                self::getBlackQueenLeftMoves($board, $number, $indexOfAbc),
                self::getBlackQueenLowerMoves($board, $number, $letter),
                self::getBlackQueenUpperMoves($board, $number, $letter),
            );
        }

        return $possibilidades;
    }
}
