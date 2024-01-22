<?php

namespace App\Services;

abstract class Piece
{
    public static $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public static function possibleMoves($board, $position, $piece) : array
    {
        return [];
    }

    public static function pieceIsWhite($piece)
    {
        return strstr($piece, 'branco');
    }

    public static function pieceIsBlack($piece)
    {
        return strstr($piece, 'preta');
    }

    public static function pieceIsBlackOrWhite($piece)
    {
        return strstr($piece, 'branco') || strstr($piece, 'preta');
    }


    //verifica se tem uma peça da mesma cor aonde na casa selecionada, caso não ter a peça é mexida
    public static function canCaptureOwnPiece($piece, $selectedPiece)
    {
        return (!strstr($piece, 'branco') && strstr($selectedPiece, 'branco'))
            || (!strstr($piece, 'preta') && strstr($selectedPiece, 'preta'));
    }

    public static function piecesAreOfDifferentColors($piece, $secoundPiece)
    {
        return (self::pieceIsWhite($piece) &&
            self::pieceIsBlack($secoundPiece)
            || self::pieceIsBlack($piece) &&
            self::pieceIsWhite($secoundPiece));
    }
}
