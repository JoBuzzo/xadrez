<?php

namespace App\Services;

class Knight extends Piece
{

    /**
     *  O cavalo tem oito casas possíveis para onde pode se mover em um único movimento, 
     *  formando um padrão de "L".
     * 
     *  . Duas casas para cima e uma para a esquerda.
     *  . Duas casas para cima e uma para a direita.
     *  . Duas casas para baixo e uma para a esquerda.
     *  . Duas casas para baixo e uma para a direita.
     *  . Uma casa para cima e duas para a esquerda.
     *  . Uma casa para cima e duas para a direita.
     *  . Uma casa para baixo e duas para a esquerda.
     *  . Uma casa para baixo e duas para a direita.
     */



    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $return = [];

        $index = array_search($letter, parent::$abc);

        /**
         * Verificar se é possivel se movimentar para cima ao lado esquerdo
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number + 2])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number + 2])
                ||  $board[parent::$abc[$index - 1] . $number + 2] == parent::$abc[$index - 1] . $number + 2
            ) {
                $return[] =  parent::$abc[$index - 1] . $number + 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para cima ao lado direito
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number + 2])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number + 2])
                || $board[parent::$abc[$index + 1] . $number + 2] == parent::$abc[$index + 1] . $number + 2

            ) {
                $return[] = parent::$abc[$index + 1] . $number + 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para baixo ao lado esquerdo
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number - 2])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number - 2])
                || $board[parent::$abc[$index - 1] . $number - 2] == parent::$abc[$index - 1] . $number - 2
            ) {
                $return[] = parent::$abc[$index - 1] . $number - 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para baixo ao lado direito
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number - 2])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number - 2])
                || $board[parent::$abc[$index + 1] . $number - 2] == parent::$abc[$index + 1] . $number - 2
            ) {
                $return[] = parent::$abc[$index + 1] . $number - 2;
            }
        }


        /**
         * Verificar se é possivel se movimentar para direita em cima
         */
        if (isset(parent::$abc[$index + 2]) && isset($board[parent::$abc[$index + 2] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 2] . $number + 1])
                || $board[parent::$abc[$index + 2] . $number + 1] == parent::$abc[$index + 2] . $number + 1
            ) {
                $return[] = parent::$abc[$index + 2] . $number + 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para direita em baixo
         */
        if (isset(parent::$abc[$index + 2]) && isset($board[parent::$abc[$index + 2] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 2] . $number - 1])
                || $board[parent::$abc[$index + 2] . $number - 1] == parent::$abc[$index + 2] . $number - 1
            ) {
                $return[] = parent::$abc[$index + 2] . $number - 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para esquerda em cima
         */
        if (isset(parent::$abc[$index - 2]) && isset($board[parent::$abc[$index - 2] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 2] . $number + 1])
                || $board[parent::$abc[$index - 2] . $number + 1] == parent::$abc[$index - 2] . $number + 1
            ) {
                $return[] = parent::$abc[$index - 2] . $number + 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para esquerda em baixo
         */
        if (isset(parent::$abc[$index - 2]) && isset($board[parent::$abc[$index - 2] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 2] . $number - 1])
                || $board[parent::$abc[$index - 2] . $number - 1] == parent::$abc[$index - 2] . $number - 1
            ) {
                $return[] = parent::$abc[$index - 2] . $number - 1;
            }
        }


        return $return;
    }
}
