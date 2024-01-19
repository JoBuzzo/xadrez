<?php

namespace App\Services;

class King
{
    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public function __invoke($board, $position, $piece)
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, $this->abc);
        $return = [];

        /**
         * Cima
         */
        if (isset($board[$letter . $number + 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$letter . $number + 1])
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
                Chess::PiecesAreOfDifferentColors($piece, $board[$letter . $number - 1])
                ||  $board[$letter . $number - 1] == $letter . $number - 1
            ) {
                $return[] = $letter . $number - 1;
            }
        }

        /**
         * Esquerda
         */
        if (isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 1] . $number])
                ||  $board[$this->abc[$index - 1] . $number] == $this->abc[$index - 1] . $number
            ) {
                $return[] = $this->abc[$index - 1] . $number;
            }
        }

        /**
         * Direita
         */
        if (isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 1] . $number])
                ||  $board[$this->abc[$index + 1] . $number] == $this->abc[$index + 1] . $number
            ) {
                $return[] = $this->abc[$index + 1] . $number;
            }
        }



        /**
         * Diagonal Esquerda Cima
         */
        if (isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number + 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 1] . $number + 1])
                ||  $board[$this->abc[$index - 1] . $number + 1] == $this->abc[$index - 1] . $number + 1
            ) {
                $return[] = $this->abc[$index - 1] . $number + 1;
            }
        }

        /**
         * Diagonal direita Cima
         */
        if (isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number + 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 1] . $number + 1])
                ||  $board[$this->abc[$index + 1] . $number + 1] == $this->abc[$index + 1] . $number + 1
            ) {
                $return[] = $this->abc[$index + 1] . $number + 1;
            }
        }

        /**
         * Diagonal Esquerda Baixo
         */
        if (isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number - 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 1] . $number - 1])
                ||  $board[$this->abc[$index - 1] . $number - 1] == $this->abc[$index - 1] . $number - 1
            ) {
                $return[] = $this->abc[$index - 1] . $number - 1;
            }
        }

        /**
         * Diagonal direita Baixo
         */
        if (isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number - 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 1] . $number - 1])
                ||  $board[$this->abc[$index + 1] . $number - 1] == $this->abc[$index + 1] . $number - 1
            ) {
                $return[] = $this->abc[$index + 1] . $number - 1;
            }
        }

        return $return;
    }
}
