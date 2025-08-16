<?php

namespace App\Services\Piece;

abstract class Piece
{
    public static $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public static $pieces = [
        'brancas' => [
            'torre_branco',
            'cavalo_branco',
            'bispo_branco',
            'rei_branco',
            'rainha_branco',
            'peao_branco'
        ],
        'pretas' => [
            'torre_preta',
            'cavalo_preta',
            'bispo_preta',
            'rei_preta',
            'rainha_preta',
            'peao_preta'
        ]
    ];

    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        return [];
    }

    public static function pieceIsWhite($piece): bool|string
    {
        return strstr($piece, 'branco');
    }
    public static function pieceAndUserIsWhite($piece, $userColor): bool
    {
        return strstr($piece, 'branco') && $userColor == 'branco';
    }

    public static function pieceIsBlack($piece): bool|string
    {
        return strstr($piece, 'preta');
    }
    public static function pieceAndUserIsBlack($piece, $userColor): bool
    {
        return strstr($piece, 'preta') && $userColor == 'preto';
    }

    public static function pieceIsBlackOrWhite($piece): bool
    {
        return strstr($piece, 'branco') || strstr($piece, 'preta');
    }


    //verifica se tem uma peça da mesma cor na casa selecionada, caso não ter a peça é mexida
    public static function canCaptureOwnPiece($piece, $selectedPiece): bool
    {
        return (!self::pieceIsWhite($piece) && self::pieceIsWhite($selectedPiece))
            || (!self::pieceIsBlack($piece) && self::pieceIsBlack($selectedPiece));
    }

    public static function piecesAreOfDifferentColors($piece, $secondPiece): bool
    {
        return (self::pieceIsWhite($piece) && self::pieceIsBlack($secondPiece)
            || self::pieceIsBlack($piece) && self::pieceIsWhite($secondPiece));
    }

    public static function getLetterAndNumber($position): array
    {
        return str_split($position, 1);
    }
}
