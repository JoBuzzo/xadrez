<?php

namespace App\Livewire;

use App\Services\Chess;
use App\Services\VerifyPiece;
use Livewire\Attributes\Title;
use Livewire\Component;

class GameChess extends Component
{
    #[Title("Xadrez")]
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

    public bool $modal = false;
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

                /**
                 * Se o peão chegar no fim do tabuleiro, aparecer as outras peças para substitui-lo
                 */
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


            $this->selectedPiece = [];
            $this->possibilities = [];
            $this->select = true;
        }
    }


    /**
     * Variavel responsável por salvar a posição em que o peão está
     */
    public $replacePosition;

    public function replacePawn($piece)
    {
        if ($piece == 'rainha' || $piece == 'torre' || $piece == 'bispo' || $piece == 'cavalo') {
            $color = $this->turn ? 'branco' : 'preta';
            $this->board[$this->replacePosition] = $piece . '_' . $color;
            $this->modal = false;
            $this->turn = !$this->turn;
            $this->replacePosition = null;
        }
    }
}
