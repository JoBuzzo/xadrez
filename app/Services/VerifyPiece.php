<?php

namespace App\Services;

class VerifyPiece
{

    public static function verify(array $board, $position, $piece)
    {
        switch ($piece) {
            case 'peao_preta' || 'peao_branco':
                $result = new Pawn;
                return $result($board, $position, $piece);
                break;
        }
    }
}
