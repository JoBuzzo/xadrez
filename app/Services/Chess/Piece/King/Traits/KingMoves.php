<?php

namespace App\Services\Chess\Piece\King\Traits;

trait KingMoves
{
    /**
     * Summary of getUpperMove
     * @param array $board
     * @param int $number
     * @param string $letter
     * @param string $piece
     * @return string[]
     */
    public static function getUpperMove(array $board, int $number, string $letter, string $piece): array
    {
        if (isset($board[$letter . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . ($number + 1)])
                ||  $board[$letter . ($number + 1)] == $letter . ($number + 1)
            ) {
                return [$letter . ($number + 1)];
            }
        }

        return [];
    }

    /**
     * Summary of getLowerMove
     * @param array $board
     * @param int $number
     * @param string $letter
     * @param string $piece
     * @return string[]
     */
    public static function getLowerMove(array $board, int $number, string $letter, string $piece): array
    {
        if (isset($board[$letter . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . ($number - 1)])
                ||  $board[$letter . ($number - 1)] == $letter . ($number - 1)
            ) {
                return [$letter . ($number - 1)];
            }
        }

        return [];
    }

    /**
     * Summary of getLeftMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getLeftMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc - 1]) && isset($board[parent::$letters[$indexOfAbc - 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 1] . $number])
                ||  $board[parent::$letters[$indexOfAbc - 1] . $number] == parent::$letters[$indexOfAbc - 1] . $number
            ) {
                return [parent::$letters[$indexOfAbc - 1] . $number];
            }
        }

        return [];
    }

    /**
     * Summary of getRightMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getRightMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc + 1]) && isset($board[parent::$letters[$indexOfAbc + 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 1] . $number])
                ||  $board[parent::$letters[$indexOfAbc + 1] . $number] == parent::$letters[$indexOfAbc + 1] . $number
            ) {
                return [parent::$letters[$indexOfAbc + 1] . $number];
            }
        }
        return [];
    }

    /**
     * Summary of getUpperRightMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getUpperRightMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc + 1]) && isset($board[parent::$letters[$indexOfAbc + 1] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 1] . ($number + 1)])
                ||  $board[parent::$letters[$indexOfAbc + 1] . ($number + 1)] == parent::$letters[$indexOfAbc + 1] . ($number + 1)
            ) {
                return [parent::$letters[$indexOfAbc + 1] . ($number + 1)];
            }
        }

        return [];
    }

    /**
     * Summary of getUpperLeftMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getUpperLeftMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc - 1]) && isset($board[parent::$letters[$indexOfAbc - 1] . ($number + 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 1] . ($number + 1)])
                ||  $board[parent::$letters[$indexOfAbc - 1] . ($number + 1)] == parent::$letters[$indexOfAbc - 1] . ($number + 1)
            ) {
                return [parent::$letters[$indexOfAbc - 1] . ($number + 1)];
            }
        }

        return [];
    }

    /**
     * Summary of getLowerRightMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getLowerRightMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc + 1]) && isset($board[parent::$letters[$indexOfAbc + 1] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc + 1] . ($number - 1)])
                ||  $board[parent::$letters[$indexOfAbc + 1] . ($number - 1)] == parent::$letters[$indexOfAbc + 1] . ($number - 1)
            ) {
                return [parent::$letters[$indexOfAbc + 1] . ($number - 1)];
            }
        }

        return [];
    }

    /**
     * Summary of getLowerLeftMove
     * @param array $board
     * @param int $number
     * @param int $indexOfAbc
     * @param string $piece
     * @return string[]
     */
    public static function getLowerLeftMove(array $board, int $number, int $indexOfAbc, string $piece): array
    {
        if (isset(parent::$letters[$indexOfAbc - 1]) && isset($board[parent::$letters[$indexOfAbc - 1] . ($number - 1)])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$letters[$indexOfAbc - 1] . ($number - 1)])
                ||  $board[parent::$letters[$indexOfAbc - 1] . ($number - 1)] == parent::$letters[$indexOfAbc - 1] . ($number - 1)
            ) {
                return [parent::$letters[$indexOfAbc - 1] . ($number - 1)];
            }
        }

        return [];
    }
}
