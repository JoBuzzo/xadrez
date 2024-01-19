<?php

namespace App\Services;

class Bishop
{
    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public function __invoke($board, $position, $piece)
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, $this->abc);
        $return = [];



        /**
         * Verificar diagonal superior direita apartir do bispo
         */

        $j = $number;
        for ($i = $index + 1; $i <= 7; $i++) {
            $j++;
            if (isset($board[$this->abc[$i] . $j])) {
                if ($board[$this->abc[$i] . $j] == $this->abc[$i] . $j) {
                    $return[] = $this->abc[$i] . $j;
                } else {
                    if (Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$i] . $j])) {
                        $return[] = $this->abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        /**
         * Verificar diagonal superior esquerda apartir do bispo
         */

        $j = $number;
        for ($i = $index - 1; $i >= 0; $i--) {
            $j++;
            if (isset($board[$this->abc[$i] . $j])) {
                if ($board[$this->abc[$i] . $j] == $this->abc[$i] . $j) {
                    $return[] = $this->abc[$i] . $j;
                } else {
                    if (Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$i] . $j])) {
                        $return[] = $this->abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        /**
         * Verificar diagonal inferior esquerda apartir do bispo
         */

        $j = $number;
        for ($i = $index - 1; $i >= 0; $i--) {
            $j--;
            if (isset($board[$this->abc[$i] . $j])) {
                if ($board[$this->abc[$i] . $j] == $this->abc[$i] . $j) {
                    $return[] = $this->abc[$i] . $j;
                } else {
                    if (Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$i] . $j])) {
                        $return[] = $this->abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        /**
         * Verificar diagonal inferior direita apartir do bispo
         */

        $j = $number;
        for ($i = $index + 1; $i <= 7; $i++) {
            $j--;
            if (isset($board[$this->abc[$i] . $j])) {
                if ($board[$this->abc[$i] . $j] == $this->abc[$i] . $j) {
                    $return[] = $this->abc[$i] . $j;
                } else {
                    if (Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$i] . $j])) {
                        $return[] = $this->abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $return;
    }
}
