<?php

namespace App\Services;

class Rook extends Piece
{

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);

        $index = array_search($letter, self::$abc);


        $return = [];

        if (parent::pieceIsWhite($piece)) {
            //verificar os espaços a esquerda apartir da posição da peça
            for ($i = $index - 1; $i >= 0; $i--) {
                if (isset(self::$abc[$i]) && isset($board[self::$abc[$i] . $number])) {
                    if (parent::pieceIsWhite($board[self::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = self::$abc[$i] . $number;
                    if (parent::pieceIsBlack($board[self::$abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset(self::$abc[$i]) && isset($board[self::$abc[$i] . $number])) {
                    if (parent::pieceIsWhite($board[self::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = self::$abc[$i] . $number;
                    if (parent::pieceIsBlack($board[self::$abc[$i] . $number])) {
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
                if (isset(self::$abc[$i]) && isset($board[self::$abc[$i] . $number])) {
                    if (parent::pieceIsBlack($board[self::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = self::$abc[$i] . $number;
                    if (parent::pieceIsWhite($board[self::$abc[$i] . $number])) {
                        break;
                    }
                }
            }


            //verificar os espaços a direita apartir da posição da peça
            for ($i = $index + 1; $i <= 7; $i++) {
                if (isset(self::$abc[$i]) && isset($board[self::$abc[$i] . $number])) {
                    if (parent::pieceIsBlack($board[self::$abc[$i] . $number])) {
                        break;
                    }
                    $return[] = self::$abc[$i] . $number;
                    if (parent::pieceIsWhite($board[self::$abc[$i] . $number])) {
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
