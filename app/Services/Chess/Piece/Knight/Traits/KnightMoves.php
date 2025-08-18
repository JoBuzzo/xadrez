<?php

namespace App\Services\Chess\Piece\Knight\Traits;

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

        if (isset(parent::$letters[$indexOfAbc + 1]) && isset($board[parent::$letters[$indexOfAbc + 1] . ($number + 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 1] . ($number + 2)])
                || $board[parent::$letters[$indexOfAbc + 1] . ($number + 2)] == parent::$letters[$indexOfAbc + 1] . ($number + 2)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc + 1] . ($number + 2);
            }
        }

        if (isset(parent::$letters[$indexOfAbc + 2]) && isset($board[parent::$letters[$indexOfAbc + 2] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 2] . ($number + 1)])
                || $board[parent::$letters[$indexOfAbc + 2] . ($number + 1)] == parent::$letters[$indexOfAbc + 2] . ($number + 1)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc + 2] . ($number + 1);
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

        if (isset(parent::$letters[$indexOfAbc - 1]) && isset($board[parent::$letters[$indexOfAbc - 1] . ($number + 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 1] . ($number + 2)])
                ||  $board[parent::$letters[$indexOfAbc - 1] . ($number + 2)] == parent::$letters[$indexOfAbc - 1] . ($number + 2)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc - 1] . ($number + 2);
            }
        }

        if (isset(parent::$letters[$indexOfAbc - 2]) && isset($board[parent::$letters[$indexOfAbc - 2] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 2] . ($number + 1)])
                || $board[parent::$letters[$indexOfAbc - 2] . ($number + 1)] == parent::$letters[$indexOfAbc - 2] . ($number + 1)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc - 2] . ($number + 1);
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

        if (isset(parent::$letters[$indexOfAbc + 1]) && isset($board[parent::$letters[$indexOfAbc + 1] . ($number - 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 1] . ($number - 2)])
                || $board[parent::$letters[$indexOfAbc + 1] . ($number - 2)] == parent::$letters[$indexOfAbc + 1] . ($number - 2)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc + 1] . ($number - 2);
            }
        }

        if (isset(parent::$letters[$indexOfAbc + 2]) && isset($board[parent::$letters[$indexOfAbc + 2] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 2] . ($number - 1)])
                || $board[parent::$letters[$indexOfAbc + 2] . ($number - 1)] == parent::$letters[$indexOfAbc + 2] . ($number - 1)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc + 2] . ($number - 1);
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

        if (isset(parent::$letters[$indexOfAbc - 1]) && isset($board[parent::$letters[$indexOfAbc - 1] . ($number - 2)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 1] . ($number - 2)])
                || $board[parent::$letters[$indexOfAbc - 1] . ($number - 2)] == parent::$letters[$indexOfAbc - 1] . ($number - 2)
            ) {
                $possibilities[] =  parent::$letters[$indexOfAbc - 1] . ($number - 2);
            }
        }

        if (isset(parent::$letters[$indexOfAbc - 2]) && isset($board[parent::$letters[$indexOfAbc - 2] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 2] . ($number - 1)])
                || $board[parent::$letters[$indexOfAbc - 2] . ($number - 1)] == parent::$letters[$indexOfAbc - 2] . ($number - 1)
            ) {
                $possibilities[] = parent::$letters[$indexOfAbc - 2] . ($number - 1);
            }
        }

        return $possibilities;
    }
}
