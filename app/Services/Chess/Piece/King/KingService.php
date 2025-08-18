<?php

namespace App\Services\Chess\Piece\King;

use App\Enums\ChessPiece;
use App\Services\Chess\Piece\Bishop\BishopService;
use App\Services\Chess\Piece\King\Traits\BlackKingMove;
use App\Services\Chess\Piece\King\Traits\KingMoves;
use App\Services\Chess\Piece\King\Traits\WhiteKingMove;
use App\Services\Chess\Piece\Knight\KnightService;
use App\Services\Chess\Piece\Pawn\PawnService;
use App\Services\Chess\Piece\Piece;
use App\Services\Chess\Piece\Queen\QueenService;
use App\Services\Chess\Piece\Rook\RookService;

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

        $indexOfAbc = array_search($letter, parent::$letters);

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

        // TODO: debugar método que remove as possibilidades onde coloca o rei em perigo
        $possibilities = self::removePossibilities($board, $position, $piece, $possibilities);

        return $possibilities;
    }

    /**
     * Summary of removePossibilities
     * @param array $board
     * @param string $position
     * @param string $piece
     * @param array $possibilities
     * @return array
     *
     */
    public static function removePossibilities(array $board, string $position, string $piece, array $possibilities): array
    {
        foreach ($board as $key => $b) {
            if ($b != $piece) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                    case ChessPiece::PAWN_BLACK:
                        $possibilitiesPawn = PawnService::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesPawn);
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                    case ChessPiece::ROOK_BLACK:
                        $possibilitiesRook = RookService::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesRook);
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                    case ChessPiece::KNIGHT_BLACK:
                        $possibilitiesKnight = KnightService::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesKnight);
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                    case ChessPiece::BISHOP_BLACK:
                        $possibilitiesBishop = BishopService::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesBishop);
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                    case ChessPiece::QUEEN_BLACK:
                        $possibilitiesQueen = QueenService::possibleMoves($board, $key, $b);
                        if (ChessPiece::getColor($piece) !== ChessPiece::getColor($b)) {
                            $possibilities = array_diff($possibilities, $possibilitiesQueen);
                        }
                        break;
                }
            }
        }

        return $possibilities;
    }
}
