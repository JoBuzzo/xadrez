<?php

namespace App\Services;

class VerifyPiece
{
    public static function verify(array $board, $position, $piece)
    {

        switch ($piece) {
            case strstr($piece, 'peao'):
                $result = new Pawn;
                return $result($board, $position, $piece);
            case strstr($piece, 'torre'):
                $result = new Tower;
                return $result($board, $position, $piece);
            case strstr($piece, 'cavalo'):
                $result = new Horse;
                return $result($board, $position, $piece);
            case strstr($piece, 'bispo'):
                $result = new Bishop;
                return $result($board, $position, $piece);
            case strstr($piece, 'rainha'):
                $result = new Queen;
                return $result($board, $position, $piece);
            case strstr($piece, 'rei'):
                $result = new King;
                return $result($board, $position, $piece);
            default:
                return [];
        }
    }
}
