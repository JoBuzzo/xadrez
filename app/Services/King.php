<?php

namespace App\Services;

use App\Enums\ChessPiece;
use App\Enums\ChessPieceColor;

class King extends Piece
{

    public static function possibleMoves($board, $position, $piece): array
    {
        [$letter, $number] = str_split($position, 1);
        $index = array_search($letter, parent::$abc);
        $return = [];

        /**
         * Cima
         */
        if (isset($board[$letter . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . $number + 1])
                ||  $board[$letter . $number + 1] == $letter . $number + 1
            ) {
                $return[] = $letter . $number + 1;
            }
        }

        /**
         * baixo
         */
        if (isset($board[$letter . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[$letter . $number - 1])
                ||  $board[$letter . $number - 1] == $letter . $number - 1
            ) {
                $return[] = $letter . $number - 1;
            }
        }

        /**
         * Esquerda
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number])
                ||  $board[parent::$abc[$index - 1] . $number] == parent::$abc[$index - 1] . $number
            ) {
                $return[] = parent::$abc[$index - 1] . $number;
            }
        }

        /**
         * Direita
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number])
                ||  $board[parent::$abc[$index + 1] . $number] == parent::$abc[$index + 1] . $number
            ) {
                $return[] = parent::$abc[$index + 1] . $number;
            }
        }



        /**
         * Diagonal Esquerda Cima
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number + 1])
                ||  $board[parent::$abc[$index - 1] . $number + 1] == parent::$abc[$index - 1] . $number + 1
            ) {
                $return[] = parent::$abc[$index - 1] . $number + 1;
            }
        }

        /**
         * Diagonal direita Cima
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number + 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number + 1])
                ||  $board[parent::$abc[$index + 1] . $number + 1] == parent::$abc[$index + 1] . $number + 1
            ) {
                $return[] = parent::$abc[$index + 1] . $number + 1;
            }
        }

        /**
         * Diagonal Esquerda Baixo
         */
        if (isset(parent::$abc[$index - 1]) && isset($board[parent::$abc[$index - 1] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index - 1] . $number - 1])
                ||  $board[parent::$abc[$index - 1] . $number - 1] == parent::$abc[$index - 1] . $number - 1
            ) {
                $return[] = parent::$abc[$index - 1] . $number - 1;
            }
        }

        /**
         * Diagonal direita Baixo
         */
        if (isset(parent::$abc[$index + 1]) && isset($board[parent::$abc[$index + 1] . $number - 1])) {
            if (
                parent::piecesAreOfDifferentColors($piece, $board[parent::$abc[$index + 1] . $number - 1])
                ||  $board[parent::$abc[$index + 1] . $number - 1] == parent::$abc[$index + 1] . $number - 1
            ) {
                $return[] = parent::$abc[$index + 1] . $number - 1;
            }
        }


        $return[] = self::roque($board, $position, $piece);

        return $return;
    }


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
     * Ao contrário da movimentação do rei e/ou torre, ter estado em xeque não remove a sua habilidade de fazer o roque depois! ✅
     *
     * O seu rei não pode entrar em xeque ao fazer o roque! Se ao mover-se para fazer o roque,
     * o rei entrar em xeque, você não pode fazer o roque! Você precisa se livrar daquela peça atacante primeiro! ✅
     *
     */
    private static function roque($board, $position, $piece)
    {
        //Roque menor
        //verificar se as casas f1 e g1 estão vazias 
        if (
            $position == 'e1' && ChessPiece::getColor($piece) == ChessPieceColor::WHITE
            && $board['h1'] == parent::$pieces['brancas'][0]
        ) {
            if ($board['f1'] == 'f1' && $board['g1'] == 'g1') {
                return 'g1';
            }
        }
        //verificar se as casas f8 e g8 estão vazias
        if (
            $position == 'e8' && ChessPiece::getColor($piece) == ChessPieceColor::BLACK
            && $board['h8'] == parent::$pieces['pretas'][0]
        ) {
            if ($board['f8'] == 'f8' && $board['g8'] == 'g8') {
                return 'g8';
            }
        }

        //Roque maior
        //verificar se as casas f1 e g1 estão vazias 
        if (
            $position == 'e1' && ChessPiece::getColor($piece) == ChessPieceColor::WHITE
            && $board['a1'] == parent::$pieces['brancas'][0]
        ) {
            if ($board['b1'] == 'b1' && $board['c1'] == 'c1' && $board['d1'] == 'd1') {
                return 'c1';
            }
        }
        //verificar se as casas f8 e g8 estão vazias
        if (
            $position == 'e8' && ChessPiece::getColor($piece) == ChessPieceColor::BLACK
            && $board['a8'] == parent::$pieces['pretas'][0]
        ) {
            if ($board['b8'] == 'b8' && $board['c8'] == 'c8' && $board['d8'] == 'd8') {
                return 'c8';
            }
        }
    }
}
