<?php

namespace App\Livewire;

use App\Events\MovedPiece;
use App\Services\Chess;
use App\Services\Piece;
use App\Services\VerifyPiece;
use App\Traits\Livewire\MultiplayerChess;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Partida Multiplayer')]
class MultiplayerGame extends Component
{
    use MultiplayerChess;

    public ?string $passant = null;

    public function mount()
    {
        $roomUuid = request()->get('room');
        $userUuid = request()->get('user');

        $this->room = Cache::get('game-match-' . $roomUuid, []);

        if (empty($this->room)) {
            session()->flash('error', 'Sala não encontrada');
            return $this->redirect(route('rooms'));
        }

        if (count($this->room['users']) == 2) {
            $this->notifySecondPlayerJoined();

            $this->waitingForOpponent = false;
        }

        $this->user = collect($this->room['users'])->firstWhere('uuid', $userUuid);

        if ($this->waitingForOpponent) {
            $this->turn = $this->user['color'] == 'branco';
        } else {
            $this->generateBoard();
            $this->turn = $this->room['turn'] == $this->user['color'];
        }
    }


    /**
     * Montar o tabuleiro de xadrez
     * - Se o tabuleiro não existir ou estiver vazio, gerar um novo tabuleiro
     * - Se o tabuleiro já existir no cache, usar o existente
     * @return void
     */
    public function generateBoard(): void
    {
        $chess = new Chess;

        if (!$this->room['board'] && $this->room['board'] == []) {
            $chess->generateBoard();
            $chess->positionPieces();
            $this->board = $chess->board;
            $this->room['board'] = $chess->board;
            Cache::put('game-match-' . $this->room['uuid'], $this->room);
        } else {
            $this->board = $this->room['board'];
        }

        $this->abc = $chess->abc;
    }

    public function move(string $position, string $piece): void
    {
        $userColor = $this->user['color'];
        $turn = $this->turn;

        $myTurn = $turn && (Piece::pieceAndUserIsWhite($piece, $userColor) || Piece::pieceAndUserIsBlack($piece, $userColor));

        if ($this->canSelectPiece && $myTurn) {
            $this->selectedPiece = [
                'position' => $position,
                'piece' => $piece
            ];
            $this->possibilities = VerifyPiece::verify($this->board, $position, $piece);
            if ($this->passant) {
                $this->possibilities[] = $this->passant;
            }
            $this->removeCastlingIfInCheck($piece, $position);
            $this->revokeCastlingRights($piece, $position);
            $this->canSelectPiece = false;
        } else if ($turn) {
            if ($this->existsPositionInPossibilities($position)) {

                $this->board[$this->selectedPiece['position']] = $this->selectedPiece['position'];
                $this->board[$position] = $this->selectedPiece['piece'];
                $this->markCastlingPiecesMoved();
                $this->executeCastlingMove($position);
                $this->verifyCheck();
                $this->handleEnPassantCapture($position);
                $this->handlePawnPromotion($position);
                event(new MovedPiece($this->board, $userColor, $this->room['uuid']));
            }

            $this->selectedPiece = [];
            $this->possibilities = [];
            $this->canSelectPiece = true;
        }
    }

    #[On('movedPieceReceived')]
    public function handleMovedPiece($data)
    {
        $this->board = $data['board'];
        $this->room['board'] = $data['board'];
        $this->room['turn'] = $data['from'] != $this->user['color'] ? 'branco' : 'preto';
        $this->turn = $data['from'] != $this->user['color'];
        Cache::put('game-match-' . $this->room['uuid'], $this->room);
    }

    public function render()
    {
        return view('livewire.multiplayer-game');
    }
}
