<?php

namespace App\Services;

class Pawn
{
    /**
     * Peão - O peão somente pode fazer movimentos adjacentes à sua posição anterior, isto é, não pode retroceder. 
     * O peão, assim como o rei só pode deslocar-se 1 casa à frente por lance, no entanto,
     * quando o peão ainda está na sua posição inicial, este pode dar um salto de 2 casas à frente.
     */

    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public function __invoke($board, $position, $piece)
    {
        [$letter, $number] = str_split($position, 1);

        if (strstr($piece, 'branco')) {
            // se o peão estiver na coluna 2 e for branco significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
            if (strstr($position, '2') && $board[$letter.$number+2] == $letter.$number+2) {
                return [
                    $letter . $number + 1,
                    $letter . $number + 2
                ];
            } else {
                $index = array_search($letter, $this->abc);

                $return = [];

                //capturar pela direita
                if (
                    isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number + 1])
                    && strstr($board[$this->abc[$index + 1] . $number + 1], 'preta')
                ) {
                    $return[] = $this->abc[$index + 1] . $number + 1;
                }

                //capturar pela esquerda
                if (
                    isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number + 1])
                    && strstr($board[$this->abc[$index - 1] . $number + 1], 'preta')
                ) {
                    $return[] = $this->abc[$index - 1] . $number + 1;
                }

                // verificar se pode andar pra frente
                if (isset($board[$letter . $number + 1]) && $board[$letter . $number + 1] == $letter . $number + 1) {
                    $return[] = $letter . $number + 1;
                }

                return $return;
            }
        }
        if (strstr($piece, 'preta')) {
            // se o peão estiver na coluna 7 e for preto significa que ele esta em sua posição inicial, sendo possível de ele andar duas casas
            if (strstr($position, '7') && $board[$letter.$number-2] == $letter.$number-2) {
                return [
                    $letter . $number - 1,
                    $letter . $number - 2
                ];
            } else {
                $index = array_search($letter, $this->abc);

                $return = [];

                //capturar pela direita
                if (
                    isset($this->abc[$index + 1]) && isset($board[$this->abc[$index + 1] . $number - 1])
                    && strstr($board[$this->abc[$index + 1] . $number - 1], 'branco')
                ) {
                    $return[] = $this->abc[$index + 1] . $number - 1;
                }

                //capturar pela esquerda
                if (
                    isset($this->abc[$index - 1]) && isset($board[$this->abc[$index - 1] . $number - 1])
                    && strstr($board[$this->abc[$index - 1] . $number - 1], 'branco')
                ) {
                    $return[] = $this->abc[$index - 1] . $number - 1;
                }

                // verificar se pode andar pra frente
                if (isset($board[$letter . $number - 1]) && $board[$letter . $number - 1] == $letter . $number - 1) {
                    $return[] = $letter . $number - 1;
                }

                return $return;
            }
        }
    }
}
