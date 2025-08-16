<?php

namespace App\Services\Piece\King;

use App\Services\Piece\King\Traits\BlackKingMove;
use App\Services\Piece\King\Traits\KingMoves;
use App\Services\Piece\King\Traits\WhiteKingMove;
use App\Services\Piece\Piece;

class KingService extends Piece
{

    /**
     * Para fazer o roque, simplesmente mova o rei duas casas para esquerda ou direita. A torre saltará sobre o rei em direção ao lado oposto automaticamente!
     *
     * Você não pode fazer o roque sempre que quiser, no entanto. Aqui estão as regras do roque:
     *
     * Seu rei não pode ter se movido! Uma vez que seu rei seja movido, você não pode mais fazer o roque,
     * mesmo que você mova o rei de volta para a sua casa inicial.
     * Muitas estratégias envolvem forçar o rei do oponente a se mover por esta razão!
     *
     * A sua torre não pode ter sido movida! Se você mover sua torre,
     * você não pode mais fazer o roque do lado da torre movida!
     * Tanto o rei quanto a torre que você está utilizando para fazer o roque não podem ter sido movidos!
     *
     * O seu rei não pode estar em xeque! Embora o roque muitas vezes pareça uma fuga interessante para o rei,
     * você não pode fazer o roque enquanto está em xeque! Uma vez que você não esteja mais em xeque, você pode fazer o roque!
     * Ao contrário da movimentação do rei e/ou torre, ter estado em xeque não remove a sua habilidade de fazer o roque depois!
     *
     * O seu rei não pode entrar em xeque ao fazer o roque! Se ao mover-se para fazer o roque,
     * o rei entrar em xeque, você não pode fazer o roque! Você precisa se livrar daquela peça atacante primeiro!
     *
     */

    use KingMoves;
    use WhiteKingMove;
    use BlackKingMove;
    /**
     * Summary of possibleMoves
     * @param array $board
     * @param string $position
     * @param string $piece
     * @return string[]
     */
    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        [$letter, $number] = parent::getLetterAndNumber($position);

        $indexOfAbc = array_search($letter, parent::$abc);

        $possibilities = array_merge(
            self::getUpperMove($board, $number, $letter, $piece),
            self::getLowerMove($board, $number, $letter, $piece),
            self::getLeftMove($board, $number, $indexOfAbc, $piece),
            self::getRightMove($board, $number, $indexOfAbc, $piece),
            self::getUpperRightMove($board, $number, $indexOfAbc, $piece),
            self::getUpperLeftMove($board, $number, $indexOfAbc, $piece),
            self::getLowerRightMove($board, $number, $indexOfAbc, $piece),
            self::getLowerLeftMove($board, $number, $indexOfAbc, $piece),

            self::getWhiteKingSmallerRoque($board, $position, $piece),
            self::getWhiteKingBiggerRoque($board, $position, $piece),
            self::getBlackKingSmallerRoque($board, $position, $piece),
            self::getBlackKingBiggerRoque($board, $position, $piece),
        );

        return $possibilities;
    }
}
