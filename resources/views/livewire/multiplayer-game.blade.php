<div class="relative flex justify-center w-full p-10">
    @if (!$waitingForOpponent)
        @php
            $opponentName =
                $room['users'][0]['uuid'] === $user['uuid'] ? $room['users'][1]['name'] : $room['users'][0]['name'];

            $turnMessage = $turn ? "Sua Vez" : "Vez de $opponentName";
        @endphp

        <div class="max-w-[1200px] w-full flex flex-col items-center">

            <div class="h-10">
                @if($check)
                    <span class="px-3 py-1 mt-2 text-sm font-semibold text-yellow-900 bg-yellow-200 rounded-full">
                        Rei em Cheque!
                    </span>
                @endif
            </div>

            <div class="flex flex-col items-center justify-between w-full gap-4 mx-auto sm:flex-row ">

                {{-- Lado esquerdo: Oponente --}}
                <div class="flex flex-col items-center text-center">
                    <span class="text-sm text-gray-500">Oponente</span>
                    <span class="text-lg font-bold">{{ $opponentName }}</span>
                </div>

                {{-- Tabuleiro --}}
                <x-chess.full-board :userColor="$user['color']" :board="$board" :abc="$abc" :selectedPiece="$selectedPiece"
                    :possibilities="$possibilities" :turn="$turn" />

                {{-- Lado direito: Jogador --}}
                <div class="flex flex-col items-center text-center">
                    <span class="text-sm text-gray-500">Você</span>
                    <span class="text-lg font-bold">{{ $user['name'] }}</span>
                    <span class="px-3 py-1 mt-2 text-sm font-semibold text-yellow-900 bg-yellow-200 rounded-full">
                        {{ $turnMessage }}
                    </span>
                </div>

            </div>
        </div>

        {{-- Modal de promoção --}}
        <x-chess.promotion-modal :modal="$modal" :color="$user['color'] == 'branco' ? 'branco' : 'preta'" />
    @else
        {{-- Esperando o oponente --}}
        <div class="flex flex-col items-center justify-center p-4 font-extrabold text-gray-700">
            <span>Olá {{ $user['name'] }}</span>
            <span>Aguarde um oponente...</span>
        </div>
    @endif
</div>

@script
    <script>
        Alpine.effect(() => {
            const roomUuid = '{{ $room['uuid'] }}';
            const userUuid = '{{ $user['uuid'] }}';

            const channel = window.Echo.channel('new-move-' + roomUuid);

            channel.listen('.moved-piece', (data) => {
                Livewire.dispatch('movedPieceReceived', {
                    data: data
                })
            });

            const startGameChannel = window.Echo.channel('start-game-' + roomUuid + '-' + userUuid);
            startGameChannel.listen('.second-player-joined', (data) => {
                startGameChannel.stopListening('.second-player-joined');
                Livewire.navigate(window.location.href);
            })

        });
    </script>
@endscript
