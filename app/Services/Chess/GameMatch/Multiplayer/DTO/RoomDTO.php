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
        public ?UserDTO $user = null,
        public ?UserDTO $oponnent = null
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

        if (count($room['users']) == 1) {
            // Caso tiver apenas um usuário, ele vai estar esperando a entrada do oponente

            $data = collect($room['users'])->firstWhere('uuid', $userUuid);
            $data['waitingForOpponent'] = true;
            $data['turn'] = Turn::isTurn($data['color']);
            $data['replacePosition'] = null;
            $data['pawnPossiton'] = null;
            $data['promotion'] = false;
            $data['check'] = false;
            $data['kingIsAlreadyMoved'] = false;
            $data['hasKingSideRookMoved'] = false;
            $data['hasQueenSideRookMoved'] = false;

            $user = UserDTO::makeUser($data);

            $room['user'] = $user;
            $room['users'] = [$user];
            $room['turn'] = $user->turn ? $user->uuid : null;

        } else if (count($room['users']) == 2) {
            // Caso tiver dois usuários, e ainda não começaram a jogar (tabuleiro vazio)
            if (!isset($room['board']) || (isset($room['board']) && $room['board'] == [])) {

                $data = collect($room['users'])->firstWhere('uuid', $userUuid);
                $data['waitingForOpponent'] = false;
                $data['turn'] = Turn::isTurn($data['color']);
                $data['replacePosition'] = null;
                $data['pawnPossiton'] = null;
                $data['passant'] = null;
                $data['promotion'] = false;
                $data['check'] = false;
                $data['kingIsAlreadyMoved'] = false;
                $data['hasKingSideRookMoved'] = false;
                $data['hasQueenSideRookMoved'] = false;

                $user = UserDTO::makeUser($data);
                $room['user'] = $user;

                $data = collect($room['users'])->firstWhere('uuid', '<>', $userUuid);
                $data['waitingForOpponent'] = false;
                $data['turn'] = Turn::isTurn($data['color']);
                $data['replacePosition'] = null;
                $data['pawnPossiton'] = null;
                $data['passant'] = null;
                $data['promotion'] = false;
                $data['check'] = false;
                $data['kingIsAlreadyMoved'] = false;
                $data['hasKingSideRookMoved'] = false;
                $data['hasQueenSideRookMoved'] = false;

                $oponnent = UserDTO::makeUser($data);
                $room['oponnent'] = $oponnent;
                $room['users'] = [$user, $oponnent];
                $room['turn'] = $user->turn ? $user->uuid : $oponnent->uuid;

                $chess = new Chess;

                $chess->generateBoard();
                $chess->positionPieces();
                $room['board'] = $chess->board;
            }else{
                // trocar vez do jogador (pensado em quando o usuário recarrega a página)
                $room['user'] = UserDTO::makeUser(collect($room['users'])->firstWhere('uuid', $userUuid));
                $room['oponnent'] = UserDTO::makeUser(collect($room['users'])->firstWhere('uuid', '<>', $userUuid));
                $room['user']->turn = !$room['user']->turn;
                $room['oponnent']->turn = !$room['oponnent']->turn;
                $room['turn'] = $room['user']->turn ? $room['user']->uuid : $room['oponnent']->uuid;
            }
        }

        return $room;
    }
}
