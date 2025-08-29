<?php

namespace App\Services\Chess\GameMatch\Multiplayer\DTO;

use App\Services\Chess\GenerateBoardService;
use Illuminate\Support\Facades\Cache;
use App\Enums\Turn;
use App\Events\SecondPlayerJoined;

class RoomDTO
{
    public function __construct(
        public string $uuid,
        public ?string $turn = null,
        public array $users,
        public array $board,
        public array $history = [],
        public ?UserDTO $user = null,
        public ?UserDTO $opponent = null
    ) {}

    public static function fromCache(string $roomUuid, string $userUuid): RoomDTO
    {
        $room = self::makeRoom($roomUuid, $userUuid);

        return new self(
            uuid: $room['uuid'],
            users: $room['users'],
            turn: $room['turn'],
            board: $room['board'],
            history: $room['history'] ?? [],
            user: $room['user'],
            opponent: $room['opponent']
        );
    }

    public function toArray(): array
    {
        $user = $this->user->toArray();
        $opponent = $this->opponent?->toArray();

        return [
            'uuid' => $this->uuid,
            'users' => [$user, $opponent],
            'turn' => $this->turn,
            'board' => $this->board,
            'history' => $this->history,
            'user' => $user,
            'opponent' => $opponent
        ];
    }

    private static function makeRoom(string $roomUuid, string $userUuid): mixed
    {
        $room = Cache::get('game-match-' . $roomUuid, []);

        if (!$room) {
            throw new \Exception('Room not found');
        }
        if (count($room['users']) == 1) {
            // Caso tiver apenas um usuário, ele vai estar esperando a entrada do oponente
            $room['history'] = [];

            $data = collect($room['users'])->firstWhere('uuid', $userUuid);
            $data['waitingForOpponent'] = true;
            $data['turn'] = Turn::isTurn($data['color']);
            $data['replacePosition'] = null;
            $data['pawnPosition'] = null;
            $data['passant'] = null;
            $data['promotion'] = false;
            $data['check'] = false;
            $data['kingIsAlreadyMoved'] = false;
            $data['hasKingSideRookMoved'] = false;
            $data['hasQueenSideRookMoved'] = false;
            $data['capturedPieces'] = [];

            $user = UserDTO::makeUser($data);

            $room['user'] = $user;
            $room['opponent'] = null;
            $room['users'] = [$user];
            $room['board'] = [];
            $room['turn'] = $user->turn ? $user->uuid : null;
        } else if (count($room['users']) == 2) {
            // Caso tiver dois usuários, e ainda não começaram a jogar (tabuleiro vazio)
            if (!isset($room['board']) || (isset($room['board']) && $room['board'] == [])) {

                $room['history'] = [];

                $data = collect($room['users'])->firstWhere('uuid', $userUuid);
                $data['waitingForOpponent'] = false;
                $data['turn'] = Turn::isTurn($data['color']);
                $data['replacePosition'] = null;
                $data['pawnPosition'] = null;
                $data['passant'] = null;
                $data['promotion'] = false;
                $data['check'] = false;
                $data['kingIsAlreadyMoved'] = false;
                $data['hasKingSideRookMoved'] = false;
                $data['hasQueenSideRookMoved'] = false;
                $data['capturedPieces'] = [];


                $user = UserDTO::makeUser($data);
                $room['user'] = $user;

                $data = collect($room['users'])->firstWhere('uuid', '<>', $userUuid);
                $data['waitingForOpponent'] = false;
                $data['turn'] = Turn::isTurn($data['color']);
                $data['replacePosition'] = null;
                $data['pawnPosition'] = null;
                $data['passant'] = null;
                $data['promotion'] = false;
                $data['check'] = false;
                $data['kingIsAlreadyMoved'] = false;
                $data['hasKingSideRookMoved'] = false;
                $data['hasQueenSideRookMoved'] = false;
                $data['capturedPieces'] = [];


                $opponent = UserDTO::makeUser($data);
                $room['opponent'] = $opponent;
                $room['users'] = [$user, $opponent];
                $room['turn'] = $user->turn ? $user->uuid : $opponent->uuid;

                $service = new GenerateBoardService;
                $room['board'] = $service->getBoard();

                // atualizar a página do adversário
                event(new SecondPlayerJoined($room['uuid'], $opponent->uuid));
            } else {
                //pensado em quando o usuário recarrega a página
                $room['user'] = UserDTO::makeUser(collect($room['users'])->firstWhere('uuid', $userUuid));

                $room['opponent'] = UserDTO::makeUser(collect($room['users'])->firstWhere('uuid', '<>', $userUuid));
            }
        }

        return $room;
    }
}
