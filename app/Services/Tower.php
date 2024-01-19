<?php

namespace App\Services;

class Tower
{
    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public function __invoke($board, $position, $piece)
    {
        [$letter, $number] = str_split($position, 1);

        $index = array_search($letter, $this->abc);

        
        $return = [];

        if (Chess::PieceIsWhite($piece)) {
            //verificar os espaços a esquerda apartir da posição da peça
            for ($i = $index - 1; $i >= 0; $i--) {
                if (isset($this->abc[$i]) && isset($board[$this->abc[$i] . $number])) {
                    if (Chess::PieceIsWhite($board[$this->abc[$i] . $number])) {
                        break;
                    }
                    $return[] = $this->abc[$i] . $number;
                    if (Chess::PieceIsBlack($board[$this->abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset($this->abc[$i]) && isset($board[$this->abc[$i] . $number])) {
                    if (Chess::PieceIsWhite($board[$this->abc[$i] . $number])) {
                        break;
                    }
                    $return[] = $this->abc[$i] . $number;
                    if (Chess::PieceIsBlack($board[$this->abc[$i] . $number])) {
                        break;
                    }
                }
            }

            //verificar os espaços em baixo apartir da posição da peça
            for ($i = $number - 1; $i >= 1; $i--) {
                if (isset($board[$letter . $i])) {
                    if (Chess::PieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (Chess::PieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                }
            }

            //verificar os espaços em cima apartir da posição da peça
            for ($i = $number + 1; $i <= 8; $i++) {
                if (isset($board[$letter . $i])) {
                    if (Chess::PieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (Chess::PieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                }
            }
        }

        if (Chess::PieceIsBlack($piece)) {
            //verificar os espaços a esquerda apartir da posição da peça
            for ($i = $index + 1; $i >= 0; $i--) {
                if (isset($this->abc[$i]) && isset($board[$this->abc[$i] . $number])) {
                    if (Chess::PieceIsBlack($board[$this->abc[$i] . $number])) {
                        break;
                    }
                    $return[] = $this->abc[$i] . $number;
                    if (Chess::PieceIsWhite($board[$this->abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset($this->abc[$i]) && isset($board[$this->abc[$i] . $number])) {
                    if (Chess::PieceIsBlack($board[$this->abc[$i] . $number])) {
                        break;
                    }
                    $return[] = $this->abc[$i] . $number;
                    if (Chess::PieceIsWhite($board[$this->abc[$i] . $number])) {
                        break;
                    }
                }
            }

            //verificar os espaços em baixo apartir da posição da peça
            for ($i = $number - 1; $i >= 1; $i--) {
                if (isset($board[$letter . $i])) {
                    if (Chess::PieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (Chess::PieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                }
            }

            //verificar os espaços em cima apartir da posição da peça
            for ($i = $number + 1; $i <= 8; $i++) {
                if (isset($board[$letter . $i])) {
                    if (Chess::PieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (Chess::PieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                }
            }
        }


        return $return;
    }
}
