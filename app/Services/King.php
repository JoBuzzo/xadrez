<?php

namespace App\Services;

class King extends Piece
{

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, parent::$abc);
        $return = [];

        /**
         * Cima
         */
        if (isset($board[$letter . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . $number + 1])
                ||  $board[$letter . $number + 1] == $letter . $number + 1
            ) {
                $return[] = $letter . $number + 1;
            }
        }

        /**
         * baixo
         */
        if (isset($board[$letter . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . $number - 1])
                ||  $board[$letter . $number - 1] == $letter . $number - 1
            ) {
                $return[] = $letter . $number - 1;
            }
        }

        /**
         * Esquerda
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number])
                ||  $board[parent::$abc[$index - 1] . $number] == parent::$abc[$index - 1] . $number
            ) {
                $return[] = parent::$abc[$index - 1] . $number;
            }
        }

        /**
         * Direita
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number])
                ||  $board[parent::$abc[$index + 1] . $number] == parent::$abc[$index + 1] . $number
            ) {
                $return[] = parent::$abc[$index + 1] . $number;
            }
        }



        /**
         * Diagonal Esquerda Cima
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number + 1])
                ||  $board[parent::$abc[$index - 1] . $number + 1] == parent::$abc[$index - 1] . $number + 1
            ) {
                $return[] = parent::$abc[$index - 1] . $number + 1;
            }
        }

        /**
         * Diagonal direita Cima
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number + 1])
                ||  $board[parent::$abc[$index + 1] . $number + 1] == parent::$abc[$index + 1] . $number + 1
            ) {
                $return[] = parent::$abc[$index + 1] . $number + 1;
            }
        }

        /**
         * Diagonal Esquerda Baixo
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number - 1])
                ||  $board[parent::$abc[$index - 1] . $number - 1] == parent::$abc[$index - 1] . $number - 1
            ) {
                $return[] = parent::$abc[$index - 1] . $number - 1;
            }
        }

        /**
         * Diagonal direita Baixo
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number - 1])
                ||  $board[parent::$abc[$index + 1] . $number - 1] == parent::$abc[$index + 1] . $number - 1
            ) {
                $return[] = parent::$abc[$index + 1] . $number - 1;
            }
        }

        return $return;
    }
}
