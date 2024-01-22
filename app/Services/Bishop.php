<?php

namespace App\Services;

class Bishop extends Piece
{

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, parent::$abc);
        $return = [];


        /**
         * Verificar diagonal superior direita apartir do bispo
         */

        $j = $number;
        for ($i = $index + 1; $i <= 7; $i++) {
            $j++;
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $return[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $return[] = parent::$abc[$i] . $j;
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
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $return[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $return[] = parent::$abc[$i] . $j;
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
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $return[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $return[] = parent::$abc[$i] . $j;
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
            if (isset($board[parent::$abc[$i] . $j])) {
                if ($board[parent::$abc[$i] . $j] == parent::$abc[$i] . $j) {
                    $return[] = parent::$abc[$i] . $j;
                } else {
                    if (parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$i] . $j])) {
                        $return[] = parent::$abc[$i] . $j;
                    }
                    break;
                }
            }
        }

        return $return;
    }
}
