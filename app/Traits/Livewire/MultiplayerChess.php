<?php

namespace App\Traits\Livewire;

use App\Events\SecondPlayerJoined;
use App\Services\Check;
use App\Services\Pawn;

trait MultiplayerChess
{

    /**
     * Variavel responsável por salvar o tabuleiro
     * @var array
     */
    public array $board = [];

    /**
     * Variavel responsável por salvar as colunas do tabuleiro
     * @var array
     */
    public array $abc = [];

    /**
     * Variavel responsável por salvar o usuário
     * que está jogando a partida
     * @var array
     *
     * $this->user['color'] = 'branco' ou 'preto'
     * $this->user['uuid'] = uuid do usuário
     *
     */
    public array $user = [];

    /**
     * Variavel responsável por salvar a vez do jogador
     * @var bool
     */
    public bool $turn = false;

    /**
     * Variavel responsável por salvar a sala
     * @var array
     * $this->room['uuid'] = uuid da sala
     * $this->room['users'] = usuários que estão na sala
     * $this->room['turn'] = cor da vez do jogador
     * $this->room['board'] = tabuleiro da partida
     */
    public array $room = [];

    /**
     * Variavel responsável por verificar se o usuário está esperando o oponente para começar a partida
     * @var bool
     */
    public bool $waitingForOpponent = true;

    /**
     * Variavel responsável por verificar se o rei está em check
     * @var bool
     */
    public bool $check = false;

    /**
     * Variavel responsável por abrir o modal de substituição do peão
     * @var bool
     */
    public bool $modal = false;

    /**
     * Variavel responsável por salvar a peça selecionada
     * @var array
     * $this->selectedPiece['position'] = posição da peça selecionada
     * $this->selectedPiece['piece'] = peça selecionada
     */
    public array $selectedPiece = [];

    /**
     * Variavel responsável por salvar as possibilidades de movimento da peça selecionada
     * @var array
     */
    public array $possibilities = [];

    /**
     * Variavel responsável por salvar a posição do peão para o movimento especial "En passant"
     * @var string|null
     */
    public ?string $passant = null;

    public ?string $pawnPosition = null;

    /**
     * Variavel responsável por salvar a posição em que o peão está
     * para substituição por outra peça quando chegar no final do tabuleiro
     * @var string|null
     */
    public ?string $replacePosition = null;

    /**
     * Variavel responsável por verificar se o rei branco já se movimentou
     * @var bool
     */
    public bool $kingWhite = false;
    /**
     * Variavel responsável por verificar se possui roque com a torre 1 branca
     * @var bool
     */
    public bool $rookWhite1 = false;
    /**
     * Variavel responsável por verificar se possui roque com a torre 2 branca
     * @var bool
     */
    public bool $rookWhite2 = false;
    /**
     * Variavel responsável por verificar se o rei preto já se movimentou
     * @var bool
     */
    public bool $kingBlack = false;
    /**
     * Variavel responsável por verificar se possui roque com a torre 1 preta
     * @var bool
     */
    public bool $rookBlack1 = false;
    /**
     * Variavel responsável por verificar se possui roque com a torre 2 preta
     * @var bool
     */
    public bool $rookBlack2 = false;

    /**
     * Variavel responsável por verificar se o usuário está selecionando uma peça
     * @var bool
     *
     * true = o usuário pode selecionar uma peça
     * false = o usuário movimenta a peça selecionada ou desseleciona outra peça
     */
    public bool $canSelectPiece = true;

    /**
     *  Substituição das peças do xadrez
     *  @param string $piece
     */
    public function replacePawn(string $piece): void
    {
        if ($piece == 'rainha' || $piece == 'torre' || $piece == 'bispo' || $piece == 'cavalo') {
            $color = $this->turn ? 'branco' : 'preta';
            $this->board[$this->replacePosition] = $piece . '_' . $color;
            $this->modal = false;
            $this->turn = !$this->turn;
            $this->replacePosition = null;
        }
    }

    /**
     * Remover a opção de realizar roque caso de check
     * @param string $piece
     * @param string $position
     * @return void
     */
    private function removeCastlingIfInCheck(string $piece, string $position): void
    {
        if ($this->check && $piece == 'rei_branco' && $position == 'e1') {
            $keysToRemove = array('g1', 'c1');

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }
        if ($this->check && $piece == 'rei_preta' && $position == 'e8') {
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
        if ($this->kingWhite && $piece == 'rei_branco' && $position == 'e1') {
            $keysToRemove = [];
            if ($this->rookWhite1) {
                array_push($keysToRemove, 'c1');
            }
            if ($this->rookWhite2) {
                array_push($keysToRemove, 'g1');
            }

            foreach ($keysToRemove as $value) {
                $key = array_search($value, $this->possibilities);
                if ($key !== false) {
                    unset($this->possibilities[$key]);
                }
            }
        }

        if ($this->kingBlack && $piece == 'rei_preta' && $position == 'e8') {
            $keysToRemove = [];
            if ($this->rookBlack1) {
                array_push($keysToRemove, 'c8');
            }
            if ($this->rookBlack2) {
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
        if ($this->selectedPiece['piece'] == 'torre_branco' && $this->selectedPiece['position'] == 'a1') {
            $this->rookWhite1 = true;
        }
        if ($this->selectedPiece['piece'] == 'torre_branco' && $this->selectedPiece['position'] == 'h1') {
            $this->rookWhite2 = true;
        }
        if ($this->selectedPiece['piece'] == 'rei_branco') {
            $this->kingWhite = true;
            $this->rookWhite1 = true;
            $this->rookWhite2 = true;
        }

        if ($this->selectedPiece['piece'] == 'torre_preta' && $this->selectedPiece['position'] == 'a8') {
            $this->rookBlack1 = true;
        }
        if ($this->selectedPiece['piece'] == 'torre_preta' && $this->selectedPiece['position'] == 'h8') {
            $this->rookBlack2 = true;
        }
        if ($this->selectedPiece['piece'] == 'rei_preta') {
            $this->kingBlack = true;
            $this->rookBlack1 = true;
            $this->rookBlack2 = true;
        }
    }

    /**
     * Executar o movimento do roque
     * @param string $position
     * @return void
     */
    private function executeCastlingMove(string $position): void
    {
        if ($this->selectedPiece['piece'] == 'rei_branco' && $position == 'g1') {
            $this->board['h1'] = 'h1';
            $this->board['f1'] = 'torre_branco';
        }
        if ($this->selectedPiece['piece'] == 'rei_branco' && $position == 'c1') {
            $this->board['a1'] = 'a1';
            $this->board['d1'] = 'torre_branco';
        }
        if ($this->selectedPiece['piece'] == 'rei_preta' && $position == 'g8') {
            $this->board['h8'] = 'h8';
            $this->board['f8'] = 'torre_preta';
        }
        if ($this->selectedPiece['piece'] == 'rei_preta' && $position == 'c8') {
            $this->board['a8'] = 'a8';
            $this->board['d8'] = 'torre_preta';
        }
    }

    /**
     * Movimento especial do peão "En passant"
     * @param string $position
     * @return void
     */
    private function handleEnPassantCapture(string $position): void
    {
        if ($position == $this->passant) {
            $this->board[$this->pawnPosition] = $this->pawnPosition;
        }
        $this->passant = Pawn::enPassant($this->board, $this->selectedPiece['position'], $position);
        if ($this->passant) {
            $this->pawnPosition = $position;
        }
    }

    /**
     * Verificar se essa peça faz check com o rei adversário nessa nova posição do tabuleiro
     * @return void
     */
    private function verifyCheck(): void
    {
        $this->check = Check::verify($this->board);
    }

    /**
     * Verificar se o peão chegou no final do tabuleiro para substituição por outra peça
     * @param string $position
     * @return void
     */
    private function handlePawnPromotion(string $position): void
    {
        if (
            strstr($this->selectedPiece['piece'], 'peao') &&
            (strstr($position, '8') == '8' || strstr($position, '1') == '1')
        ) {
            //abrir modal de escolher a peça
            $this->replacePosition = $position;
            $this->modal = true;
        } else {
            $this->turn = !$this->turn;
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
        if (!isset($this->room['board']) || (isset($this->room['board']) && $this->room['board'] == [])) {
            event(new SecondPlayerJoined($this->room['uuid'], $this->room['users'][0]['uuid']));
        }
    }
}
