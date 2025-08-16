<?php

namespace App\Services\Chess\Piece\Knight;

use App\Services\Chess\Piece\Knight\Traits\KnightMoves;
use App\Services\Chess\Piece\Piece;

class KnightService extends Piece
{
    use KnightMoves;
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

    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = str_split($position, 1);

        $index = array_search($letter, parent::$abc);

        return array_merge(
            self::getKnightUpperRightMoves($board, $number, $index, $piece),
            self::getKnightUpperLeftMoves($board, $number, $index, $piece),
            self::getKnightLowerRightMoves($board, $number, $index, $piece),
            self::getKnightLowerLeftMoves($board, $number, $index, $piece),
        );
    }
}
