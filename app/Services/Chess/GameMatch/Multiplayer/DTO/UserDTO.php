<?php

namespace App\Services\Chess\GameMatch\Multiplayer\DTO;

class UserDTO
{
    public string $uuid;
    /**
     * Variavel responsável por identificar o nome do usuário
     * @var string
     */
    public string $name;

    /**
     * Variavel responsável por identificar as peças do usuário
     * @var string
     */
    public string $color;
    /**
     * Variavel responsável por verificar se o rei está em check
     * @var bool
     */
    public bool $check = false;

    /**
     * Variavel responsável por verificar se o usuário está esperando o oponente para começar a partida
     * @var bool
     */
    public bool $waitingForOpponent = false;

    /**
     * Variavel responsável por abrir o modal de substituição do peão
     * @var bool
     */
    public bool $promotion = false;

    /**
     * Variavel responsável por salvar a posição em que o peão está
     * para substituição por outra peça quando chegar no final do tabuleiro
     * @var string|null
     */
    public ?string $replacePosition = null;

    /**
     * Variavel responsável por salvar a possição do peão na passant
     * @var
     */
    public ?string $pawnPosition = null;

    /**
     * Variavel responsável por salvar a posição do peão para o movimento especial "En passant"
     * @var string|null
     */
    public ?string $passant = null;

    /**
     * Variavel responsável por identificar a vez do jogador
     * @var bool
     */
    public bool $turn = false;
    /**
     * Variavel responsável por verificar se o rei já se movimentou
     * para não deixar efetuar o roque
     * @var bool
     */
    public bool $kingIsAlreadyMoved = false;
    /**
     * Variavel responsável por verificar se a torre do lado do rei ja se movimentou
     * para não deixar efetuar o roque do lado do rei
     * @var bool
     */
    public bool $hasKingSideRookMoved = false;

    /**
     * Variavel responsável por verificar se a torre do lado da rainha ja se movimentou
     * para não deixar efetuar o roque do lado da rainha
     * @var bool
     */
    public bool $hasQueenSideRookMoved = false;

    public function __construct(
        string $uuid,
        string $name,
        string $color,
        bool $check,
        bool $waitingForOpponent,
        bool $promotion,
        ?string $replacePosition,
        ?string $pawnPosition,
        ?string $passant,
        bool $turn,
        bool $kingIsAlreadyMoved,
        bool $hasKingSideRookMoved,
        bool $hasQueenSideRookMoved
    ) {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->color = $color;
        $this->check = $check;
        $this->waitingForOpponent = $waitingForOpponent;
        $this->promotion = $promotion;
        $this->replacePosition = $replacePosition;
        $this->pawnPosition = $pawnPosition;
        $this->passant = $passant;
        $this->turn = $turn;
        $this->kingIsAlreadyMoved = $kingIsAlreadyMoved;
        $this->hasKingSideRookMoved = $hasKingSideRookMoved;
        $this->hasQueenSideRookMoved = $hasQueenSideRookMoved;
    }

    public static function makeUser(array $data): UserDTO
    {
        return new self(
            uuid: $data['uuid'],
            name: $data['name'],
            color: $data['color'],
            check: $data['check'],
            waitingForOpponent: $data['waitingForOpponent'],
            promotion: $data['promotion'],
            replacePosition: $data['replacePosition'],
            pawnPosition: $data['pawnPosition'],
            passant: $data['passant'],
            turn: $data['turn'],
            kingIsAlreadyMoved: $data['kingIsAlreadyMoved'],
            hasKingSideRookMoved: $data['hasKingSideRookMoved'],
            hasQueenSideRookMoved: $data['hasQueenSideRookMoved']
        );
    }

    public function toArray(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'color' => $this->color,
            'check' => $this->check,
            'waitingForOpponent' => $this->waitingForOpponent,
            'promotion' => $this->promotion,
            'replacePosition' => $this->replacePosition,
            'pawnPosition' => $this->pawnPosition,
            'passant' => $this->passant,
            'turn' => $this->turn,
            'kingIsAlreadyMoved' => $this->kingIsAlreadyMoved,
            'hasKingSideRookMoved' => $this->hasKingSideRookMoved,
            'hasQueenSideRookMoved' => $this->hasQueenSideRookMoved
        ];
    }
}
