<?php

use App\Livewire\Chess\GameMatch\Multiplayer\ChessGameMatch;
use App\Livewire\Room;
use Illuminate\Support\Facades\Route;

Route::get('/multiplayer/partida', ChessGameMatch::class)->name('multiplayer.game.chess');
Route::get('/', Room::class)->name('rooms');
