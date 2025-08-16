<?php

namespace App\Services\Chess\GameMatch;

use App\Enums\ChessPiece;
use App\Services\Chess\Piece\Bishop\BishopService;
use App\Services\Chess\Piece\King\KingService;
use App\Services\Chess\Piece\Knight\KnightService;
use App\Services\Chess\Piece\Pawn\PawnService;
use App\Services\Chess\Piece\Queen\QueenService;
use App\Services\Chess\Piece\Rook\RookService;

class MatchPiecesService
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

    public static function checkWhiteKing(array $board)
    {
        $positionKingWhite = array_search(ChessPiece::KING_WHITE, $board);
        foreach ($board as $key => $b) {
            if ($b != $key) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                        $possibilities = PawnService::possibleMoves($board, $key, $b);
                        if (in_array($positionKingWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                        $possibilities = RookService::possibleMoves($board, $key, $b);
                        if (in_array($positionKingWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                        $possibilities = KnightService::possibleMoves($board, $key, $b);
                        if (in_array($positionKingWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                        $possibilities = BishopService::possibleMoves($board, $key, $b);
                        if (in_array($positionKingWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                        $possibilities = QueenService::possibleMoves($board, $key, $b);
                        if (in_array($positionKingWhite, $possibilities)) {
                            return true;
                        }
                        break;
                }
            }
        }
        return false;
    }
    public static function checkBlackKing(array $board)
    {
        $positionBlackWhite = array_search(ChessPiece::KING_BLACK, $board);
        foreach ($board as $key => $b) {
            if ($b != $key) {
                switch ($b) {
                    case ChessPiece::PAWN_WHITE:
                        $possibilities = PawnService::possibleMoves($board, $key, $b);
                        if (in_array($positionBlackWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::ROOK_WHITE:
                        $possibilities = RookService::possibleMoves($board, $key, $b);
                        if (in_array($positionBlackWhite, $possibilities)) {
                            $return = true;
                        }
                        break;
                    case ChessPiece::KNIGHT_WHITE:
                        $possibilities = KnightService::possibleMoves($board, $key, $b);
                        if (in_array($positionBlackWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::BISHOP_WHITE:
                        $possibilities = BishopService::possibleMoves($board, $key, $b);
                        if (in_array($positionBlackWhite, $possibilities)) {
                            return true;
                        }
                        break;
                    case ChessPiece::QUEEN_WHITE:
                        $possibilities = QueenService::possibleMoves($board, $key, $b);
                        if (in_array($positionBlackWhite, $possibilities)) {
                            return true;
                        }
                        break;
                }
            }
        }
        return false;
    }
}
