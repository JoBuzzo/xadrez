<?php

namespace App\Services\Chess\GameMatch;

use App\Enums\ChessPiece;
use App\Services\Chess\Piece\Bishop\BishopService;
use App\Services\Chess\Piece\King\KingService;
use App\Services\Chess\Piece\Knight\KnightService;
use App\Services\Chess\Piece\Pawn\PawnService;
use App\Services\Chess\Piece\Queen\QueenService;
use App\Services\Chess\Piece\Rook\RookService;

class MatchPieces
{
    public static function matchPieces(array $board, string $position, string $piece): array
    {
        return match ($piece) {
            ChessPiece::PAWN_WHITE, ChessPiece::PAWN_BLACK => PawnService::possibleMoves($board, $position, $piece),
            ChessPiece::ROOK_WHITE, ChessPiece::ROOK_BLACK => RookService::possibleMoves($board, $position, $piece),
            ChessPiece::KNIGHT_WHITE, ChessPiece::KNIGHT_BLACK => KnightService::possibleMoves($board, $position, $piece),
            ChessPiece::BISHOP_WHITE, ChessPiece::BISHOP_BLACK => BishopService::possibleMoves($board, $position, $piece),
            ChessPiece::QUEEN_WHITE, ChessPiece::QUEEN_BLACK => QueenService::possibleMoves($board, $position, $piece),
            ChessPiece::KING_WHITE, ChessPiece::KING_BLACK => KingService::possibleMoves($board, $position, $piece),
            default => []
        };
    }
}
