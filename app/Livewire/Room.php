<?php

namespace App\Livewire;

use App\Events\RefreshRooms;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;

#[Title('Salas de Xadrez')]
class Room extends Component
{
    public function render()
    {
        return view('livewire.room');
    }
    public array $rooms;

    public function mount()
    {
        $this->rooms = Cache::remember('rooms', 60 *  60 * 60, function () {
            return $this->generateRooms();
        });
    }

    public function joinRoom(string $uuid, string $userName)
    {
        $index = null;

        $this->rooms = Cache::get('rooms', $this->rooms);

        foreach ($this->rooms as $key => $room) {
            if ($room['uuid'] === $uuid) {
                $index = $key;
                break;
            }
        }

        if ($index === null) {
            session()->flash('error', 'Sala não encontrada');
            return;
        }

        $newUser = [
            'uuid' => (string) Str::uuid(),
            'name' => $userName,
        ];

        $countUsers = count($this->rooms[$index]['users']);

        if ($countUsers == 0) {
            $newUser['color'] = random_int(0, 1) ? 'white' : 'black';
            $this->rooms[$index]['users'][] = $newUser;
        } else if ($countUsers == 1) {
            $newUser['color'] = $this->rooms[$index]['users'][0]['color'] == 'white' ? 'black' : 'white';
            $this->rooms[$index]['users'][] = $newUser;
        } else {
            session()->flash('error', 'Sala cheia');
            return;
        }

        Cache::put('rooms', $this->rooms);

        $room = $this->rooms[$index];

        $cachedGameMatch = Cache::get('game-match-' . $room['uuid']);

        if ($cachedGameMatch) {
            $cachedGameMatch['users'][] = $newUser;
            $room = $cachedGameMatch;
        }

        Cache::put('game-match-' . $room['uuid'], $room);
        event(new RefreshRooms($this->rooms));
        $this->redirect(route('multiplayer.game.chess', ['room' => $uuid, 'user' => $newUser['uuid']]), true);
    }


    public function generateRooms(): array
    {
        $rooms = [];

        for ($index = 1; $index <= 5; $index++) {
            $rooms[] = [
                'uuid' => (string) Str::uuid(),
                'name' => 'Sala ' . $index,
                'users' => [],
                'board' => [],
            ];
        }

        return $rooms;
    }

    #[On('refresh-rooms')]
    public function handleRefreshRooms($data)
    {
        $this->rooms = $data['rooms'] ?? Cache::get('rooms', $this->rooms);
    }
}
