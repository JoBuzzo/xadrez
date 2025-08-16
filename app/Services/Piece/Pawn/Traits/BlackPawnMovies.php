<?php

namespace App\Services\Piece\Pawn\Traits;

use App\Enums\ChessPiece;

trait BlackPawnMovies
{
    /**
     * Summary of getBlackPawnInitialMoves
     * Se o peão estiver na coluna 7 e for preto significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string[]
     */
    public static function getBlackPawnInitialMoves(array $board, string $letter, int $number): array
    {
        $isOnStartingRank = $number === 7;

        $oneAhead = $letter . ($number - 1);
        $twoAhead = $letter . ($number - 2);

        $isOneAheadEmpty = $board[$oneAhead] === $oneAhead;
        $isTwoAheadEmpty = $board[$twoAhead] === $twoAhead;

        if ($isOnStartingRank && $isOneAheadEmpty && $isTwoAheadEmpty) {
            return [$oneAhead, $twoAhead];
        }

        return [];
    }

    /**
     * Summary of getBlackPawnCaptures
     * verifica se o peão preto pode capturar uma peça branca
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string|string[]
     */
    public static function getBlackPawnCaptures(array $board, string $letter, int $number): array
    {
        $possibilities = [];

        $index = array_search($letter, parent::$abc);

        $canCaptureRight = isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number - 1])
            && parent::pieceIsWhite($board[parent::$abc[$index + 1] . $number - 1]);

        $canCaptureLeft = isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number - 1])
            && parent::pieceIsWhite($board[parent::$abc[$index - 1] . $number - 1]);

        if ($canCaptureRight) {
            $possibilities[] = parent::$abc[$index + 1] . $number - 1;
        }

        if ($canCaptureLeft) {
            $possibilities = parent::$abc[$index - 1] . $number - 1;
        }

        return $possibilities;
    }

    /**
     * Summary of getBlackPawnMoves
     * Verifica se o peão preto pode avançar uma casa
     * @param array $board
     * @param string $letter
     * @param int $number
     * @return string[]
     */
    public static function getBlackPawnMoves(array $board, string $letter, int $number): array
    {
        $canAdvanceOne = isset($board[$letter . ($number - 1)])
            && $board[$letter . ($number - 1)] == $letter . ($number - 1);

        if ($canAdvanceOne) {
            return [$letter . ($number - 1)];
        }

        return [];
    }

    /**
     * Summary of getBlackPawnEnPassant
     * @param array $board
     * @param int $number1
     * @param int $number2
     * @param string $letter2
     * @return string|null
     */
    public static function getBlackPawnEnPassant(array $board, int $number1, int $number2, string $letter2): string|null
    {
        if ($number1 - 2 == $number2) {
            $pos = array_search($letter2, parent::$abc);

            $canCaptureRight = (isset(parent::$abc[$pos + 1]) && isset($board[parent::$abc[$pos + 1] . $number2])) &&
                ($board[parent::$abc[$pos + 1] . $number2] == ChessPiece::PAWN_WHITE);

            $canCaptureLeft = (isset(parent::$abc[$pos - 1]) && isset($board[parent::$abc[$pos - 1] . $number2])) &&
                ($board[parent::$abc[$pos - 1] . $number2] == ChessPiece::PAWN_WHITE);

            if ($canCaptureRight || $canCaptureLeft) {
                return $letter2 . $number1 - 1;
            }
        }
        
        return null;
    }
}
