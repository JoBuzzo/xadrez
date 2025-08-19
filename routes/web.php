<?php

use App\Livewire\Chess\GameMatch\Multiplayer\ChessGameMatch;
use App\Livewire\Room;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/multiplayer/partida', ChessGameMatch::class)->name('multiplayer.game.chess');
Route::get('/', Room::class)->name('rooms');

/**
 * TODO:
 * - implementar movimento que obriga tirar o rei de cheque (não deixar mover o rei para a captura e nem mexer uma peça que não tira o cheque)
 * - implemetar fim do jogo (rei capturado ou desistencia)
 */
