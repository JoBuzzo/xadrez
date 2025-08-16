<?php

namespace App\Services\Piece\Bishop\Traits;

trait BishopMoves
{
    /**
     * Summary of getBishopUpperRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getBishopUpperRightMoves(array $board, int $number, int $indexOfAbc, $piece): array
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
     * Summary of getBishopUpperLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getBishopUpperLeftMoves(array $board, int $number, int $indexOfAbc, $piece): array
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
     * Summary of getBishopLowerRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getBishopLowerRightMoves(array $board, int $number, int $indexOfAbc, $piece): array
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
     * Summary of getBishopLowerLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getBishopLowerLeftMoves(array $board, int $number, int $indexOfAbc, $piece): array
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
