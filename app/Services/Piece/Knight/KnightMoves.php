<?php

namespace App\Services\Piece\Knight;

trait KnightMoves
{
    /**
     * Summary of getKnightUpperRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getKnightUpperRightMoves(array $board, int $number, int $indexOfAbc, $piece): array
    {
        $possibilities = [];

        if (isset(parent::$abc[$indexOfAbc + 1]) && isset($board[parent::$abc[$indexOfAbc + 1] . ($number + 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc + 1] . ($number + 2)])
                || $board[parent::$abc[$indexOfAbc + 1] . ($number + 2)] == parent::$abc[$indexOfAbc + 1] . ($number + 2)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc + 1] . ($number + 2);
            }
        }

        if (isset(parent::$abc[$indexOfAbc + 2]) && isset($board[parent::$abc[$indexOfAbc + 2] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc + 2] . ($number + 1)])
                || $board[parent::$abc[$indexOfAbc + 2] . ($number + 1)] == parent::$abc[$indexOfAbc + 2] . ($number + 1)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc + 2] . ($number + 1);
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getKnightUpperLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getKnightUpperLeftMoves(array $board, int $number, int $indexOfAbc, $piece): array
    {
        $possibilities = [];

        if (isset(parent::$abc[$indexOfAbc - 1]) && isset($board[parent::$abc[$indexOfAbc - 1] . ($number + 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc - 1] . ($number + 2)])
                ||  $board[parent::$abc[$indexOfAbc - 1] . ($number + 2)] == parent::$abc[$indexOfAbc - 1] . ($number + 2)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc - 1] . ($number + 2);
            }
        }

        if (isset(parent::$abc[$indexOfAbc - 2]) && isset($board[parent::$abc[$indexOfAbc - 2] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc - 2] . ($number + 1)])
                || $board[parent::$abc[$indexOfAbc - 2] . ($number + 1)] == parent::$abc[$indexOfAbc - 2] . ($number + 1)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc - 2] . ($number + 1);
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getKnightLowerRightMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getKnightLowerRightMoves(array $board, int $number, int $indexOfAbc, $piece): array
    {
        $possibilities = [];

        if (isset(parent::$abc[$indexOfAbc + 1]) && isset($board[parent::$abc[$indexOfAbc + 1] . ($number - 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc + 1] . ($number - 2)])
                || $board[parent::$abc[$indexOfAbc + 1] . ($number - 2)] == parent::$abc[$indexOfAbc + 1] . ($number - 2)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc + 1] . ($number - 2);
            }
        }

        if (isset(parent::$abc[$indexOfAbc + 2]) && isset($board[parent::$abc[$indexOfAbc + 2] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc + 2] . ($number - 1)])
                || $board[parent::$abc[$indexOfAbc + 2] . ($number - 1)] == parent::$abc[$indexOfAbc + 2] . ($number - 1)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc + 2] . ($number - 1);
            }
        }

        return $possibilities;
    }

    /**
     * Summary of getKnightLowerLeftMoves
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param mixed $piece
     * @return string[]
     */
    public static function getKnightLowerLeftMoves(array $board, int $number, int $indexOfAbc, $piece): array
    {
        $possibilities = [];

        if (isset(parent::$abc[$indexOfAbc - 1]) && isset($board[parent::$abc[$indexOfAbc - 1] . ($number - 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc - 1] . ($number - 2)])
                || $board[parent::$abc[$indexOfAbc - 1] . ($number - 2)] == parent::$abc[$indexOfAbc - 1] . ($number - 2)
            ) {
                $possibilities[] =  parent::$abc[$indexOfAbc - 1] . ($number - 2);
            }
        }

        if (isset(parent::$abc[$indexOfAbc - 2]) && isset($board[parent::$abc[$indexOfAbc - 2] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$indexOfAbc - 2] . ($number - 1)])
                || $board[parent::$abc[$indexOfAbc - 2] . ($number - 1)] == parent::$abc[$indexOfAbc - 2] . ($number - 1)
            ) {
                $possibilities[] = parent::$abc[$indexOfAbc - 2] . ($number - 1);
            }
        }

        return $possibilities;
    }
}
