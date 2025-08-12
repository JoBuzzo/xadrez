<?php

namespace App\Livewire;

use App\Events\MovedPiece;
use App\Services\Check;
use App\Services\Chess;
use App\Services\EscapeCheck;
use App\Services\Pawn;
use App\Services\Piece;
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
    public bool $check = false;


    public $passant;
    public $pawnPosition;

    public $kingWhite = false;
    public $rookWhite1 = false;
    public $rookWhite2 = false;

    public $kingBlack = false;
    public $rookBlack1 = false;
    public $rookBlack2 = false;
    public function move($position, $piece)
    {
        if ($this->select) {

            if ($this->turn && Piece::pieceIsWhite($piece) || !$this->turn && Piece::pieceIsBlack($piece)) {

                $this->selectedPiece = [
                    'position' => $position,
                    'piece' => $piece
                ];
                $this->select = false;
                //verifica que tipo de peça foi selecionada e mostra quais casas é possível de movimentar a peça selecionada
                $this->possibilities = VerifyPiece::verify($this->board, $position, $piece);
                if ($this->passant) {
                    $this->possibilities[] = $this->passant;
                }

                // if ($this->check) {
                //     $this->possibilities = EscapeCheck::verify($this->board, $position, $piece);
                // }

                /**
                 * remover a opção do roque caso de check
                 */
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

                /**
                 * remover a opção do roque caso a torre ou rei se movimentou
                 * branco
                 */
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

                /**
                 * remover a opção do roque caso a torre ou rei se movimentou
                 * preta
                 */
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
        } else {

            if (in_array($position, $this->possibilities)) {
                $this->board[$this->selectedPiece['position']] = $this->selectedPiece['position'];
                $this->board[$position] = $this->selectedPiece['piece'];


                /**
                 * Verificar se é o rei ou a torre que se movimentou para o Roque
                 */
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

                /**
                 * Roque (Mudar a torre junto com o rei)
                 */
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



                if ($position == $this->passant) {
                    $this->board[$this->pawnPosition] = $this->pawnPosition;
                }
                /**
                 * Verificar se essa peça faz check com o rei adversário nessa nova posição do tabuleiro
                 * ....
                 */
                $this->check = Check::verify($this->board);


                /**
                 * Movimento especial do peão "En passant"
                 */
                $this->passant = Pawn::enPassant($this->board, $this->selectedPiece['position'], $position);
                if ($this->passant) {
                    $this->pawnPosition = $position;
                }

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

            event(new MovedPiece($this->board, $this->turn ? 'branco' : 'preta'));
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
