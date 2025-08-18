<?php

namespace App\Services\Chess\GameMatch\Multiplayer\Traits;

use App\Services\Chess\GameMatch\Multiplayer\DTO\SelectedPieceDTO;
use App\Services\Chess\GameMatch\Multiplayer\DTO\RoomDTO;
use App\Services\Chess\Piece\Pawn\PawnService;
use App\Events\SecondPlayerJoined;

trait ChessGameMatch
{
    /**
     * Summary of room
     * @var RoomDTO
     */
    private RoomDTO $room;

    /**
     * Variavel responsável por salvar as possibilidades de movimento da peça selecionada
     * @var array
     */
    private array $possibilities = [];

    /**
     * Summary of selectedPiece
     * @var SelectedPieceDTO
     */
    private ?SelectedPieceDTO $selectedPiece = null;

    /**
     * Variavel responsável por verificar se o usuário está selecionando uma peça
     * @var bool
     *
     * true = o usuário pode selecionar uma peça
     * false = o usuário movimenta a peça selecionada ou desseleciona outra peça
     */
    private bool $canSelectPiece = true;


    /**
     * Remover a opção de realizar roque caso de check
     * @param string $piece
     * @param string $position
     * @return void
     */
    private function removeCastlingIfInCheck(string $piece, string $position): void
    {
        $whiteKingIsInCheck = $this->userIsWhite() ? $this->room->user->check : $this->room->opponent->check;
        $blackKingIsInCheck = $this->userIsWhite() ? $this->room->opponent->check : $this->room->user->check;

        if ($whiteKingIsInCheck && $piece == 'rei_branco' && $position == 'e1') {
            $keysToRemove = array('g1', 'c1');

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }
        if ($blackKingIsInCheck && $piece == 'rei_preta' && $position == 'e8') {
            $keysToRemove = array('g8',  'c8');

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }
    }

    /**
     * Remover a opção de roque caso a torre ou rei se movimentou
     * @param string $piece
     * @param string $position
     * @return void
     */
    private function revokeCastlingRights(string $piece, string $position): void
    {

        $whiteUser = $this->userIsWhite() ? $this->room->user : $this->room->opponent;
        $blackUser = $this->userIsWhite() ? $this->room->opponent : $this->room->user;

        if ($whiteUser->kingIsAlreadyMoved && $piece == 'rei_branco' && $position == 'e1') {
            $keysToRemove = [];
            if ($whiteUser->hasQueenSideRookMoved) {
                array_push($keysToRemove, 'c1');
            }
            if ($this->hasKingSideRookMoved) {
                array_push($keysToRemove, 'g1');
            }

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }

        if ($blackUser->kingIsAlreadyMoved && $piece == 'rei_preta' && $position == 'e8') {
            $keysToRemove = [];
            if ($blackUser->hasQueenSideRookMoved) {
                array_push($keysToRemove, 'c8');
            }
            if ($blackUser->hasKingSideRookMoved) {
                array_push($keysToRemove, 'g8');
            }

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }
    }

    /**
     * Verifica se a posição existe nas possibilidades de movimento da peça selecionada
     * @param string $position
     * @return bool
     */
    private function existsPositionInPossibilities(string $position): bool
    {
        return in_array($position, $this->possibilities);
    }

    /**
     * Verificar se é o rei ou a torre que se movimentou para o Roque
     * @return void
     */
    private function markCastlingPiecesMoved(): void
    {
        if ($this->selectedPiece->piece == 'torre_branco' && $this->selectedPiece->position == 'a1') {
            $this->room->user->hasQueenSideRookMoved = true;
        }
        if ($this->selectedPiece->piece == 'torre_branco' && $this->selectedPiece->position == 'h1') {
            $this->room->user->hasKingSideRookMoved = true;
        }
        if ($this->selectedPiece->piece == 'rei_branco') {
            $this->room->user->kingIsAlreadyMoved = true;
            $this->room->user->hasQueenSideRookMoved = true;
            $this->room->user->hasKingSideRookMoved = true;
        }

        if ($this->selectedPiece->piece == 'torre_preta' && $this->selectedPiece->position == 'a8') {
            $this->room->opponent->hasQueenSideRookMoved = true;
        }
        if ($this->selectedPiece->piece == 'torre_preta' && $this->selectedPiece->position == 'h8') {
            $this->room->opponent->hasKingSideRookMoved = true;
        }
        if ($this->selectedPiece->piece == 'rei_preta') {
            $this->room->opponent->kingIsAlreadyMoved = true;
            $this->room->opponent->hasQueenSideRookMoved = true;
            $this->room->opponent->hasKingSideRookMoved = true;
        }
    }

    /**
     * Executar o movimento do roque
     * @param string $position
     * @return void
     */
    private function executeCastlingMove(string $position): void
    {
        if ($this->selectedPiece->piece == 'rei_branco' && $position == 'g1') {
            $this->room->board['h1'] = 'h1';
            $this->room->board['f1'] = 'torre_branco';
        }
        if ($this->selectedPiece->piece == 'rei_branco' && $position == 'c1') {
            $this->room->board['a1'] = 'a1';
            $this->room->board['d1'] = 'torre_branco';
        }
        if ($this->selectedPiece->piece == 'rei_preta' && $position == 'g8') {
            $this->room->board['h8'] = 'h8';
            $this->room->board['f8'] = 'torre_preta';
        }
        if ($this->selectedPiece->piece == 'rei_preta' && $position == 'c8') {
            $this->room->board['a8'] = 'a8';
            $this->room->board['d8'] = 'torre_preta';
        }
    }

    /**
     * Movimento especial do peão "En passant"
     * @param string $position
     * @return void
     */
    private function handleEnPassantCapture(string $position): void
    {
        if ($position == $this->room->user->passant) {
            $this->room->board[$this->room->user->pawnPosition] = $this->room->user->pawnPosition;
        }
        $this->room->user->passant = PawnService::enPassant($this->room->board, $this->selectedPiece->position, $position);
        if ($this->room->user->passant) {
            $this->room->user->pawnPosition = $position;
        }
    }

    /**
     * Verificar se o peão chegou no final do tabuleiro para substituição por outra peça
     * @param string $position
     * @return void
     */
    private function handlePawnPromotion(string $position): void
    {
        if (
            strstr($this->selectedPiece->piece, 'peao') &&
            (strstr($position, '8') == '8' || strstr($position, '1') == '1')
        ) {
            //abrir modal de escolher a peça
            $this->room->user->replacePosition = $position;
            $this->room->user->promotion = true;
        } else {
            $this->room->turn = $this->room->turn == $this->room->user->uuid ? $this->room->opponent->uuid : $this->room->user->uuid;
        }
    }

    /**
     * Atualiza a página do primeiro jogador que está esperando o segundo jogador entrar
     * - Se o tabuleiro não existir ou estiver vazio, notifica
     * - Se o tabuleiro já existir, não faz nada
     * @return void
     */
    private function notifySecondPlayerJoined(): void
    {
        if (!isset($this->room->board) || (isset($this->room->board) && $this->room->board == [] && $this->room->opponent?->uuid)) {
            event(new SecondPlayerJoined($this->room->uuid, $this->room->opponent->uuid));
        }
    }

    private function userIsWhite(): bool
    {
        return $this->room->user->color == 'white';
    }
}
