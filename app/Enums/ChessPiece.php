<?php

namespace App\Enums;

enum ChessPiece
{
    const PAWN_WHITE = 'white_pawn';
    const ROOK_WHITE = 'white_rook';
    const KNIGHT_WHITE = 'white_knight';
    const BISHOP_WHITE = 'white_bishop';
    const QUEEN_WHITE = 'white_queen';
    const KING_WHITE = 'white_king';

    const PAWN_BLACK = 'black_pawn';
    const ROOK_BLACK = 'black_rook';
    const KNIGHT_BLACK = 'black_knight';
    const BISHOP_BLACK = 'black_bishop';
    const QUEEN_BLACK = 'black_queen';
    const KING_BLACK = 'black_king';


    public static function getColor(string $piece): string
    {
        return str_starts_with($piece, 'white_') ? ChessPieceColor::WHITE : ChessPieceColor::BLACK;
    }
}
