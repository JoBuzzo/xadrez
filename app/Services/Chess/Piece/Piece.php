<?php

namespace App\Services\Chess\Piece;

abstract class Piece
{
    public static array $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public static $pieces = [
        'whites' => [
            'white_rook',
            'white_knight',
            'white_bishop',
            'white_king',
            'white_queen',
            'white_pawn'
        ],
        'blacks' => [
            'black_rook',
            'black_knight',
            'black_bishop',
            'black_king',
            'black_queen',
            'black_pawn'
        ]
    ];

    public static function possibleMoves(array $board, string $position, string $piece): array
    {
        return [];
    }

    public static function pieceIsWhite($piece): bool|string
    {
        return strstr($piece, 'white');
    }
    public static function pieceAndUserIsWhite($piece, $userColor): bool
    {
        return strstr($piece, 'white') && $userColor == 'white';
    }

    public static function pieceIsBlack($piece): bool|string
    {
        return strstr($piece, 'black');
    }
    public static function pieceAndUserIsBlack($piece, $userColor): bool
    {
        return strstr($piece, 'black') && $userColor == 'black';
    }

    public static function pieceIsBlackOrWhite($piece): bool
    {
        return strstr($piece, 'white') || strstr($piece, 'black');
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
