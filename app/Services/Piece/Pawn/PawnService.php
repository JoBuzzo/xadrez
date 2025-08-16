<?php

namespace App\Services\Piece\Pawn;

use App\Services\Piece\Pawn\Traits\BlackPawnMoves;
use App\Services\Piece\Pawn\Traits\WhitePawnMoves;
use App\Services\Piece\Piece;

class PawnService extends Piece
{
    /**
     * Peão - O peão somente pode fazer movimentos adjacentes à sua posição anterior, isto é, não pode retroceder.
     * O peão, assim como o rei só pode deslocar-se 1 casa à frente por lance, no entanto,
     * quando o peão ainda está na sua posição inicial, este pode dar um salto de 2 casas à frente.
     */

    use WhitePawnMoves;
    use BlackPawnMoves;

    /**
     * Summary of possibleMoves
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return array
     */
    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = parent::getLetterAndNumber($position);
        $possibilities = [];

        if (parent::pieceIsWhite($piece)) {

            $possibilities = array_merge(
                $possibilities,
                self::getWhitePawnInitialMoves($board, $letter, $number),
                self::getWhitePawnCaptures($board, $letter, $number),
                self::getWhitePawnMoves($board, $letter, $number)
            );
        } else if (parent::pieceIsBlack($piece)) {

            $possibilities = array_merge(
                $possibilities,
                self::getBlackPawnInitialMoves($board, $letter, $number),
                self::getBlackPawnCaptures($board, $letter, $number),
                self::getBlackPawnMoves($board, $letter, $number)
            );
        }

        return $possibilities;
    }


    /**
     * Summary of enPassant
     * Movimento especial do peão "En passant"
     * @param array $board
     * @param string $previousPosition
     * @param string $currentPosition
     * @return string|null
     */
    public static function enPassant(array $board, string $previousPosition, string $currentPosition): string|null
    {
        $number1 = str_split($previousPosition, 1)[1];
        [$letter2, $number2] = str_split($currentPosition, 1);

        return self::getWhitePawnEnPassant($board, $number1, $number2, $letter2)
            ?? self::getBlackPawnEnPassant($board, $number1, $number2, $letter2) ?? null;
    }
}
