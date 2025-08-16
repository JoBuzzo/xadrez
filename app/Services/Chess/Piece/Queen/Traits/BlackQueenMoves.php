<?php

namespace App\Services\Chess\Piece\Queen\Traits;

trait BlackQueenMoves
{
    /**
     * Summary of getBlackQueenRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @return string[]
     */
    public static function getBlackQueenRightMoves(array $board, int $number, int $indexOfAbc): array
    {
        $possibilities = [];

        for ($i = $indexOfAbc + 1; $i <= 7; $i++) {
            if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                    break;
                }
                $possibilities[] = parent::$abc[$i] . $number;
                if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getBlackQueenLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @return string[]
     */
    public static function getBlackQueenLeftMoves(array $board, int $number, int $indexOfAbc): array
    {
        $possibilities = [];

        for ($i = $indexOfAbc - 1; $i >= 0; $i--) {
            if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                    break;
                }
                $possibilities[] = parent::$abc[$i] . $number;
                if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getBlackQueenLowerMoves
     * @param array $board
     * @param int $number
     * @param string $letter
     * @return string[]
     */
    public static function getBlackQueenLowerMoves(array $board, int $number, string $letter): array
    {
        $possibilities = [];

        for ($i = $number - 1; $i >= 1; $i--) {
            if (isset($board[$letter . $i])) {
                if (parent::pieceIsBlack($board[$letter . $i])) {
                    break;
                }
                $possibilities[] = $letter . $i;
                if (parent::pieceIsWhite($board[$letter . $i])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getBlackQueenUpperMoves
     * @param array $board
     * @param int $number
     * @param string $letter
     * @return string[]
     */
    public static function getBlackQueenUpperMoves(array $board, int $number, string $letter): array
    {
        $possibilities = [];

        for ($i = $number + 1; $i <= 8; $i++) {
            if (isset($board[$letter . $i])) {
                if (parent::pieceIsBlack($board[$letter . $i])) {
                    break;
                }
                $possibilities[] = $letter . $i;
                if (parent::pieceIsWhite($board[$letter . $i])) {
                    break;
                }
            }
        }

        return $possibilities;
    }
}
