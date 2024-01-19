<?php

namespace App\Livewire;

use App\Services\Chess;
use App\Services\VerifyPiece;
use Livewire\Component;

class GameChess extends Component
{
    public function render()
    {
        return view('livewire.game-chess');
    }

    public $board = [];
    public $abc = [];

    public function mount()
    {
        $chess = new Chess;
        $chess->generateBoard();
        $chess->positionPieces();

        $this->board = $chess->board;
        $this->abc = $chess->abc;
    }

    /**
     * true: seleciona a peça
     * false: movimenta a peça selecionada e a desseleciona
     * @var boolean
     */
    public $select = true;

    /**
     * Vez
     * true: peças brancas
     * false: peças pretas
     *
     * @var boolean
     */
    public $turn = true;


    /**
     * exemplo: ['position'] => a1
     * exemplo: ['piece'] => peao_branco
     *
     * @var array
     */
    public array $selectedPiece;
    public array $possibilities;

    public function move($position, $piece)
    {
        if ($this->select) {

            if ($this->turn && Chess::PieceIsWhite($piece) || !$this->turn && Chess::PieceIsBlack($piece)) {
                $this->selectedPiece = [
                    'position' => $position,
                    'piece' => $piece
                ];
                $this->select = false;
                //verifica que tipo de peça foi selecionada e mostra quais casas é possível de movimentar a peça selecionada
                $this->possibilities = VerifyPiece::verify($this->board, $position, $piece);
            }


        } else {
            if (in_array($position, $this->possibilities)) {
                $this->board[$this->selectedPiece['position']] = $this->selectedPiece['position'];
                $this->board[$position] = $this->selectedPiece['piece'];
                $this->turn = ! $this->turn;
            }
            $this->selectedPiece = [];
            $this->possibilities = [];
            $this->select = true;
        }
    }
}
