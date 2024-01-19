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
                break;
            case strstr($piece, 'torre'):
                $result = new Tower;
                return $result($board, $position, $piece);
                break;
        }
    }
}
