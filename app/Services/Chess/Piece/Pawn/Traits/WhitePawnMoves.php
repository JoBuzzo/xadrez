<?php

namespace App\Services\Chess\Piece\Pawn\Traits;

use App\Enums\ChessPiece;

trait WhitePawnMoves
{
    /**
     * Summary of getWhitePawnInitialMoves
     * Se o peão estiver na coluna 2 e for branco significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string[]
     */
    public static function getWhitePawnInitialMoves(array $board, string $letter, int $number): array
    {
        $isOnStartingRank = $number === 2;

        $oneAhead = $letter . ($number + 1);
        $twoAhead = $letter . ($number + 2);

        $isOneAheadEmpty = $board[$oneAhead] === $oneAhead;
        $isTwoAheadEmpty = $board[$twoAhead] === $twoAhead;

        if ($isOnStartingRank && $isOneAheadEmpty && $isTwoAheadEmpty) {
            return [$oneAhead, $twoAhead];
        }

        return [];
    }

    /**
     * Summary of getWhitePawnCaptures
     * Verifica se o peão branco pode capturar uma peça preta
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string[]
     */
    public static function getWhitePawnCaptures(array $board, string $letter, int $number): array
    {
        $possibilities = [];

        $index = array_search($letter, parent::$letters);

        $canCaptureRight = isset(parent::$letters[$index + 1]) && isset($board[parent::$letters[$index + 1] . $number + 1])
            && parent::pieceIsBlack($board[parent::$letters[$index + 1] . $number + 1]);

        $canCaptureLeft = isset(parent::$letters[$index - 1]) && isset($board[parent::$letters[$index - 1] . $number + 1])
            && parent::pieceIsBlack($board[parent::$letters[$index - 1] . $number + 1]);

        if ($canCaptureRight) {
            $possibilities[] = parent::$letters[$index + 1] . $number + 1;
        }

        if ($canCaptureLeft) {
            $possibilities[] = parent::$letters[$index - 1] . $number + 1;
        }

        return $possibilities;
    }

    /**
     * Summary of getWhitePawnMoves
     * Verifica se o peão branco pode avançar uma casa
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string[]
     */
    public static function getWhitePawnMoves(array $board, string $letter, int $number): array
    {
        $canAdvanceOne = isset($board[$letter . ($number + 1)])
            && $board[$letter . ($number + 1)] == $letter . ($number + 1);

        if ($canAdvanceOne) {
            return [$letter . ($number + 1)];
        }

        return [];
    }

    /**
     * Summary of getWhitePawnEnPassant
     * @param array $board
     * @param int $number1
     * @param int $number2
     * @param string $letter2
     * @return string|null
     */
    public static function getWhitePawnEnPassant(array $board, int $number1, int $number2, string $letter2): string|null
    {
        if ($number1 + 2 == $number2) {
            $pos = array_search($letter2, parent::$letters);

            $canCaptureRight = (isset(parent::$letters[$pos + 1]) && isset($board[parent::$letters[$pos + 1] . $number2])) &&
                ($board[parent::$letters[$pos + 1] . $number2] == ChessPiece::PAWN_BLACK);

            $canCaptureLeft = (isset(parent::$letters[$pos - 1]) && isset($board[parent::$letters[$pos - 1] . $number2])) &&
                ($board[parent::$letters[$pos - 1] . $number2] == ChessPiece::PAWN_BLACK);

            if ($canCaptureRight || $canCaptureLeft) {
                return $letter2 . ($number1 + 1);
            }
        }

        return null;
    }
}
