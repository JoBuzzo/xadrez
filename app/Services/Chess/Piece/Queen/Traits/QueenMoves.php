<?php

namespace App\Services\Chess\Piece\Queen\Traits;

trait QueenMoves
{
    /**
     * Summary of getQueenUpperRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getQueenUpperRightMoves(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        $possibilities = [];

        $j = $number;
        for ($i = $indexOfAbc + 1; $i <= 7; $i++) {
            $j++;
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $possibilities[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $possibilities[] = parent::$abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getQueenUpperLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getQueenUpperLeftMoves(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        $possibilities = [];

        $j = $number;
        for ($i = $indexOfAbc - 1; $i >= 0; $i--) {
            $j++;
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $possibilities[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $possibilities[] = parent::$abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getQueenLowerRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getQueenLowerRightMoves(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        $possibilities = [];

        $j = $number;
        for ($i = $indexOfAbc + 1; $i <= 7; $i++) {
            $j--;
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $possibilities[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $possibilities[] = parent::$abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getQueenLowerLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getQueenLowerLeftMoves(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        $possibilities = [];

        $j = $number;
        for ($i = $indexOfAbc - 1; $i >= 0; $i--) {
            $j--;
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $possibilities[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $possibilities[] = parent::$abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $possibilities;
    }
}
