<?php

namespace App\Services\Chess\Piece\Queen\Traits;

trait WhiteQueenMoves
{
    /**
     * Summary of getWhiteQueenRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @return string[]
     */
    public static function getWhiteQueenRightMoves(array $board, int $number, int $indexOfAbc): array
    {
        $possibilities = [];

        for ($i = $indexOfAbc - 1; $i >= 0; $i--) {
            if (isset(parent::$letters[$i]) && isset($board[parent::$letters[$i] . $number])) {
                if (parent::pieceIsWhite($board[parent::$letters[$i] . $number])) {
                    break;
                }
                $possibilities[] = parent::$letters[$i] . $number;
                if (parent::pieceIsBlack($board[parent::$letters[$i] . $number])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getWhiteQueenLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @return string[]
     */
    public static function getWhiteQueenLeftMoves(array $board, int $number, int $indexOfAbc): array
    {
        $possibilities = [];

        for ($i = $indexOfAbc - 1; $i >= 0; $i--) {
            if (isset(parent::$letters[$i]) && isset($board[parent::$letters[$i] . $number])) {
                if (parent::pieceIsWhite($board[parent::$letters[$i] . $number])) {
                    break;
                }
                $possibilities[] = parent::$letters[$i] . $number;
                if (parent::pieceIsBlack($board[parent::$letters[$i] . $number])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getWhiteQueenLowerMoves
     * @param array $board
     * @param int $number
     * @param string $letter
     * @return string[]
     */
    public static function getWhiteQueenLowerMoves(array $board, int $number, string $letter): array
    {
        $possibilities = [];

        for ($i = $number - 1; $i >= 1; $i--) {
            if (isset($board[$letter . $i])) {
                if (parent::pieceIsWhite($board[$letter . $i])) {
                    break;
                }
                $possibilities[] = $letter . $i;
                if (parent::pieceIsBlack($board[$letter . $i])) {
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getWhiteQueenUpperMoves
     * @param array $board
     * @param int $number
     * @param string $letter
     * @return string[]
     */
    public static function getWhiteQueenUpperMoves(array $board, int $number, string $letter): array
    {
        $possibilities = [];

        for ($i = $number + 1; $i <= 8; $i++) {
            if (isset($board[$letter . $i])) {
                if (parent::pieceIsWhite($board[$letter . $i])) {
                    break;
                }
                $possibilities[] = $letter . $i;
                if (parent::pieceIsBlack($board[$letter . $i])) {
                    break;
                }
            }
        }

        return $possibilities;
    }
}
