<?php

use App\Livewire\Chess\GameMatch\Multiplayer\ChessGameMatch;
use App\Livewire\Room;
use Illuminate\Support\Facades\Route;

Route::get('/multiplayer/partida', ChessGameMatch::class)->name('multiplayer.game.chess');
Route::get('/', Room::class)->name('rooms');

/**
 * TODO:
 * - ajustar cheque (não está aparecendo que o rei ficou em cheque)
 *
 * - ajustar bug de captura do rei (testando indentifiquei que o rei pode caminhar umas casas a mais na captura na diagonal superior direita,
 * testei novamente após mexer a torre e não foi mais possível, pode ser algo haver com o roque)
 *
 * - implementar movimento que obriga tirar o rei de cheque (não deixar mover o rei para a captura e nem mexer uma peça que não tira o cheque)
 *
 * - implemetar fim do jogo (rei capturado ou desistencia)
 */
