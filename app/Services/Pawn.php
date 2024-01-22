<?php

namespace App\Services;

class Pawn extends Piece
{
    /**
     * Peão - O peão somente pode fazer movimentos adjacentes à sua posição anterior, isto é, não pode retroceder. 
     * O peão, assim como o rei só pode deslocar-se 1 casa à frente por lance, no entanto,
     * quando o peão ainda está na sua posição inicial, este pode dar um salto de 2 casas à frente.
     */

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $return = [];

        if (parent::pieceIsWhite($piece)) {
            // se o peão estiver na coluna 2 e for branco significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
            if (strstr($position, '2') && $board[$letter . $number + 1] == $letter . $number + 1 && $board[$letter . $number + 2] == $letter . $number + 2) {
                $return[] = $letter . $number + 1;
                $return[] = $letter . $number + 2;
            }
            $index = array_search($letter, parent::$abc);

            /**
             * Capturar pela direita
             * 
             * verifica se tem casas a diagonal direita e se tem peças pretas nessa diagonal
             */
            if (
                isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number + 1])
                && parent::pieceIsBlack($board[parent::$abc[$index + 1] . $number + 1])
            ) {
                $return[] = parent::$abc[$index + 1] . $number + 1;
            }

            /**
             * Capturar pela esquerda
             * 
             * verifica se tem casas a diagonal esquerda e se tem peças pretas nessa diagonal
             */
            if (
                isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number + 1])
                && parent::pieceIsBlack($board[parent::$abc[$index - 1] . $number + 1])
            ) {
                $return[] = parent::$abc[$index - 1] . $number + 1;
            }

            // verificar se pode andar pra frente
            if (isset($board[$letter . $number + 1]) && $board[$letter . $number + 1] == $letter . $number + 1) {
                $return[] = $letter . $number + 1;
            }

            return $return;
        }
        if (parent::pieceIsBlack($piece)) {
            // se o peão estiver na coluna 7 e for preto significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
            if (strstr($position, '7') && $board[$letter . $number - 1] == $letter . $number - 1 && $board[$letter . $number - 2] == $letter . $number - 2) {
                $return[] = $letter . $number - 1;
                $return[] = $letter . $number - 2;
            }
            $index = array_search($letter, parent::$abc);

            /**
             * Capturar pela direita
             * 
             * verifica se tem casas a diagonal direita e se tem peças brancas nessa diagonal
             */
            if (
                isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number - 1])
                && parent::pieceIsWhite($board[parent::$abc[$index + 1] . $number - 1])
            ) {
                $return[] = parent::$abc[$index + 1] . $number - 1;
            }

            /**
             * Capturar pela esquerda
             * 
             * verifica se tem casas a diagonal esquerda e se tem peças brancas nessa diagonal
             */
            if (
                isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number - 1])
                && parent::pieceIsWhite($board[parent::$abc[$index - 1] . $number - 1])
            ) {
                $return[] = parent::$abc[$index - 1] . $number - 1;
            }

            // verificar se pode andar pra frente
            if (isset($board[$letter . $number - 1]) && $board[$letter . $number - 1] == $letter . $number - 1) {
                $return[] = $letter . $number - 1;
            }

            return $return;
        }
    }
}
