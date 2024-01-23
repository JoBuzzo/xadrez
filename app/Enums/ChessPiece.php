<?php

namespace App\Enums;

enum ChessPiece
{
    const PAWN_WHITE = 'peao_branco';
    const ROOK_WHITE = 'torre_branco';
    const KNIGHT_WHITE = 'cavalo_branco';
    const BISHOP_WHITE = 'bispo_branco';
    const QUEEN_WHITE = 'rainha_branco';
    const KING_WHITE = 'rei_branco';

    const PAWN_BLACK = 'peao_preta';
    const ROOK_BLACK = 'torre_preta';
    const KNIGHT_BLACK = 'cavalo_preta';
    const BISHOP_BLACK = 'bispo_preta';
    const QUEEN_BLACK = 'rainha_preta';
    const KING_BLACK = 'rei_preta';


    public static function getColor(string $piece): string
    {
        return str_ends_with($piece, '_branco') ? ChessPieceColor::WHITE : ChessPieceColor::BLACK;
    }
}
