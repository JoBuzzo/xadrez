<?php

namespace App\Services\Chess\GameMatch\Multiplayer\DTO;

use App\Enums\Turn;
use App\Services\Chess;
use Illuminate\Support\Facades\Cache;

class RoomDTO
{
    public function __construct(
        public string $uuid,
        public ?string $turn = null,
        public array $users,
        public array $board,
        public array $user,
        public array $oponnent
    ) {}

    public static function fromCache(): RoomDTO
    {
        $room = self::makeRoom();

        return new self(
            uuid: $room['uuid'],
            users: $room['users'],
            turn: $room['turn'],
            board: $room['board'],
            user: $room['user'],
            oponnent: $room['oponnent']
        );
    }

    private static function makeRoom()
    {
        $roomUuid = request()->get('room');
        $userUuid = request()->get('user');

        $room = Cache::get('game-match-' . $roomUuid, []);

        if (count($room) == 1) {
            // Caso tiver apenas um usuário, ele vai estar esperando a entrada do oponente
            $room['user'] = collect($room['users'])->firstWhere('uuid', $userUuid);
            $room['user']['waitingForOpponent'] = true;
            $room['user']['turn'] = Turn::isTurn($room['user']['color']);
            $room['user']['replacePosition'] = null;
            $room['user']['promotion'] = false;
            $room['user']['check'] = false;

            $room['users'] = [$room['user']];
            $room['turn'] = $room['user']['turn'] ? $room['user']['uuid'] : null;

        } else if (count($room['users']) == 2) {
            // Caso tiver dois usuários, e ainda não começaram a jogar (tabuleiro vazio)
            if (!isset($room['board']) || (isset($room['board']) && $room['board'] == [])) {

                $room['user'] = collect($room['users'])->firstWhere('uuid', $userUuid);
                $room['user']['waitingForOpponent'] = false;
                $room['user']['turn'] = Turn::isTurn($room['user']['color']);
                $room['user']['replacePosition'] = null;
                $room['user']['promotion'] = false;
                $room['user']['check'] = false;

                $room['oponnent'] = collect($room['users'])->firstWhere('uuid', '<>', $userUuid);
                $room['oponnent']['waitingForOpponent'] = false;
                $room['oponnent']['turn'] = !Turn::isTurn($room['user']['color']);
                $room['oponnent']['replacePosition'] = null;
                $room['oponnent']['promotion'] = false;
                $room['oponnent']['check'] = false;


                $room['users'] = [$room['user'], $room['oponnent']];
                $room['turn'] = $room['user']['turn'] ? $room['user']['uuid'] : $room['user']['oponnent'];

                $chess = new Chess;

                $chess->generateBoard();
                $chess->positionPieces();
                $room['board'] = $chess->board;
            }else{
                // trocar vez do jogador (pensado em quando o usuário recarrega a página)
                $room['user'] = collect($room['users'])->firstWhere('uuid', $userUuid);
                $room['user']['turn'] = !$room['user']['turn'];
                $room['oponnent']['turn'] = !$room['oponnent']['turn'];
                $room['turn'] = $room['user']['turn'] ? $room['user']['uuid'] : $room['oponnent']['uuid'];
            }
        }

        return $room;
    }
}
