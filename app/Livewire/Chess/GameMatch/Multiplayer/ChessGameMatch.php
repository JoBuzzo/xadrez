<?php

namespace App\Livewire\Chess\GameMatch\Multiplayer;

use App\Services\Chess\GameMatch\Multiplayer\ChessGameMatchService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\Component;

#[Title('Partida Multiplayer')]
class ChessGameMatch extends Component
{
    public string $roomUuid;
    public string $userUuid;
    public array $room;
    public array $board = [];
    public array $user = [];
    public array $opponent = [];
    public array $selectedPiece = [];
    public bool $canSelectPiece = true;
    public array $possibilities = [];

    public function mount(): void
    {
        try {
            $this->roomUuid = request()->get('room');
            $this->userUuid = request()->get('user');
            $service = new ChessGameMatchService($this->roomUuid, $this->userUuid);

            $this->setData($service);
        } catch (\Throwable $th) {
            $this->redirect(route('rooms'), true);
        }
    }

    public function handleSquareClick(string $position, string $piece): void
    {
        $service = new ChessGameMatchService(
            $this->roomUuid,
            $this->userUuid,
            $this->canSelectPiece,
            $this->selectedPiece,
            $this->possibilities
        );

        $service->handleSquareClick($position, $piece);
        $this->setData($service);
    }

    #[On('movedPieceReceived')]
    public function handleMovedPiece(array $data): void
    {
        $service = new ChessGameMatchService($this->roomUuid, $this->userUuid);
        $service->handleMovedPiece($data);
        $this->setData($service);
    }

    public function replacePawn(string $piece)
    {
        $service = new ChessGameMatchService(
            $this->roomUuid,
            $this->userUuid,
            $this->canSelectPiece,
            $this->selectedPiece,
            $this->possibilities
        );

        $service->replacePawn($piece);
        $this->setData($service);
    }

    private function setData(ChessGameMatchService $service): void
    {
        $this->room = $service->getRoom();
        $this->board = $service->getBoard();
        $this->user = $service->getUser();
        $this->opponent = $service->getOpponent();
        $this->canSelectPiece = $service->getCanSelectPiece();
        $this->selectedPiece = $service->getSelectedPiece();
        $this->possibilities = $service->getPossibilities();
    }

    public function render(): Factory|View
    {
        return view('livewire.chess.game-match.multiplayer.chess-game-match');
    }
}
