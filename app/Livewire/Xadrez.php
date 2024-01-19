<?php

namespace App\Livewire;

use App\Services\Chess;
use App\Services\Peao;
use App\Services\VerifyPiece;
use Livewire\Component;

class Xadrez extends Component
{
    public function render()
    {
        return view('livewire.xadrez');
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

    public $number = 0;
    public array $selectedPiece;
    public array $possibilities;

    public function move($position, $piece)
    {
        switch ($this->number) {
            case 0:
                if (strstr($piece, 'branco') || strstr($piece, 'preta')) {
                    $this->selectedPiece = [
                        'position' => $position,
                        'piece' => $piece
                    ];
                    $this->number++;
                    //verificar que tipo de peça foi selecionada e mostrar quais casas é possível de movimentar
                    //...
                    $this->possibilities = VerifyPiece::verify($this->board, $position, $piece);
                }
                break;
            case 1:
                if (
                    ((!strstr($piece, 'branco') && strstr($this->selectedPiece['piece'], 'branco'))
                    || (!strstr($piece, 'preta') && strstr($this->selectedPiece['piece'], 'preta')))
                    && in_array($position, $this->possibilities)
                ) {
                    $this->board[$this->selectedPiece['position']] = $this->selectedPiece['position'];
                    $this->board[$position] = $this->selectedPiece['piece'];
                }
                $this->selectedPiece = [];
                $this->possibilities = [];
                $this->number--;
                break;
        }
    }
}
