<?php

namespace App\Services;

class Queen extends Piece
{

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, parent::$abc);
        $return = [];



        /**
         * Verificar diagonal superior direita apartir da rainha
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
         * Verificar diagonal superior esquerda apartir da rainha
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
         * Verificar diagonal inferior esquerda apartir da rainha
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
         * Verificar diagonal inferior direita apartir da rainha
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

        if (parent::pieceIsWhite($piece)) {
            //verificar os espaços a esquerda apartir da posição da peça
            for ($i = $index - 1; $i >= 0; $i--) {
                if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                    if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = parent::$abc[$i] . $number;
                    if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                    if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = parent::$abc[$i] . $number;
                    if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                }
            }

            //verificar os espaços em baixo apartir da posição da peça
            for ($i = $number - 1; $i >= 1; $i--) {
                if (isset($board[$letter . $i])) {
                    if (parent::pieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (parent::pieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                }
            }

            //verificar os espaços em cima apartir da posição da peça
            for ($i = $number + 1; $i <= 8; $i++) {
                if (isset($board[$letter . $i])) {
                    if (parent::pieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (parent::pieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                }
            }
        }

        if (parent::pieceIsBlack($piece)) {
            //verificar os espaços a esquerda apartir da posição da peça
            for ($i = $index - 1; $i >= 0; $i--) {
                if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                    if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = parent::$abc[$i] . $number;
                    if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset(parent::$abc[$i]) && isset($board[parent::$abc[$i] . $number])) {
                    if (parent::pieceIsBlack($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = parent::$abc[$i] . $number;
                    if (parent::pieceIsWhite($board[parent::$abc[$i] . $number])) {
                        break;
                    }
                }
            }

            //verificar os espaços em baixo apartir da posição da peça
            for ($i = $number - 1; $i >= 1; $i--) {
                if (isset($board[$letter . $i])) {
                    if (parent::pieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (parent::pieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                }
            }

            //verificar os espaços em cima apartir da posição da peça
            for ($i = $number + 1; $i <= 8; $i++) {
                if (isset($board[$letter . $i])) {
                    if (parent::pieceIsBlack($board[$letter . $i])) {
                        break;
                    }
                    $return[] = $letter . $i;
                    if (parent::pieceIsWhite($board[$letter . $i])) {
                        break;
                    }
                }
            }
        }

        return $return;
    }
}
