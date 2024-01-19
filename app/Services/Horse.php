<?php

namespace App\Services;

class Horse
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


    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public function __invoke($board, $position, $piece)
    {
        [$letter, $number] = str_split($position, 1);
        $return = [];

        $index = array_search($letter, $this->abc);

        /**
         * Verificar se é possivel se movimentar para cima ao lado esquerdo
         */
        if (isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number + 2])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 1] . $number + 2])
                ||  $board[$this->abc[$index - 1] . $number + 2] == $this->abc[$index - 1] . $number + 2
            ) {
                $return[] =  $this->abc[$index - 1] . $number + 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para cima ao lado direito
         */
        if (isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number + 2])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 1] . $number + 2])
                || $board[$this->abc[$index + 1] . $number + 2] == $this->abc[$index + 1] . $number + 2

            ) {
                $return[] = $this->abc[$index + 1] . $number + 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para baixo ao lado esquerdo
         */
        if (isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number - 2])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 1] . $number - 2])
                || $board[$this->abc[$index - 1] . $number - 2] == $this->abc[$index - 1] . $number - 2
            ) {
                $return[] = $this->abc[$index - 1] . $number - 2;
            }
        }

        /**
         * Verificar se é possivel se movimentar para baixo ao lado direito
         */
        if (isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number - 2])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 1] . $number - 2])
                || $board[$this->abc[$index + 1] . $number - 2] == $this->abc[$index + 1] . $number - 2
            ) {
                $return[] = $this->abc[$index + 1] . $number - 2;
            }
        }


        /**
         * Verificar se é possivel se movimentar para direita em cima
         */
        if (isset($this->abc[$index + 2]) && isset($board[$this->abc[$index + 2] . $number + 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 2] . $number + 1])
                || $board[$this->abc[$index + 2] . $number + 1] == $this->abc[$index + 2] . $number + 1
            ) {
                $return[] = $this->abc[$index + 2] . $number + 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para direita em baixo
         */
        if (isset($this->abc[$index + 2]) && isset($board[$this->abc[$index + 2] . $number - 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index + 2] . $number - 1])
                || $board[$this->abc[$index + 2] . $number - 1] == $this->abc[$index + 2] . $number - 1
            ) {
                $return[] = $this->abc[$index + 2] . $number - 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para esquerda em cima
         */
        if (isset($this->abc[$index - 2]) && isset($board[$this->abc[$index - 2] . $number + 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 2] . $number + 1])
                || $board[$this->abc[$index - 2] . $number + 1] == $this->abc[$index - 2] . $number + 1
            ) {
                $return[] = $this->abc[$index - 2] . $number + 1;
            }
        }

        /**
         * Verificar se é possivel se movimentar para esquerda em baixo
         */
        if (isset($this->abc[$index - 2]) && isset($board[$this->abc[$index - 2] . $number - 1])) {
            if (
                Chess::PiecesAreOfDifferentColors($piece, $board[$this->abc[$index - 2] . $number - 1])
                || $board[$this->abc[$index - 2] . $number - 1] == $this->abc[$index - 2] . $number - 1
            ) {
                $return[] = $this->abc[$index - 2] . $number - 1;
            }
        }


        return $return;
    }
}
