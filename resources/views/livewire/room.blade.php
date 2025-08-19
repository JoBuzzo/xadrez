<div x-data="{ showModal: false, selectedRoomId: null, userName: '' }" class="max-w-4xl p-4 mx-auto">

    <h2 class="mb-6 text-2xl font-bold text-center text-gray-800">Salas de Xadrez</h2>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
        @foreach ($rooms as $room)
            <div
                class="p-5 transition-shadow duration-300 bg-white rounded-lg shadow-md hover:shadow-xl"
            >
                <h3 class="mb-3 text-xl font-semibold text-gray-900">{{ $room['name'] }}</h3>
                <p class="mb-4 text-gray-600">
                    Usuários:
                    @if(count($room['users']) > 0)
                        @foreach ($room['users'] as $user)
                            <span
                                class="inline-block px-2 py-1 mr-2 text-sm text-white bg-blue-500 rounded-full"
                            >
                                {{ $user['name'] }}
                            </span>
                        @endforeach
                    @else
                        Nenhum usuário
                    @endif
                </p>
                <button
                    @click="
                        selectedRoomId = '{{ $room['uuid'] }}';
                        userName = '';
                        showModal = true;
                    "
                    class="w-full py-2 text-white transition bg-blue-600 rounded-md hover:bg-blue-700"
                >
                    Entrar na sala
                </button>
            </div>
        @endforeach
    </div>

    <!-- Modal -->
    <div
        x-show="showModal"
        x-transition
        style="display: none"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div
            @click.away="showModal = false"
            class="w-full max-w-md p-6 mx-2 bg-white rounded-lg"
        >
            <h3 class="mb-4 text-xl font-semibold text-gray-900">Entrar na Sala</h3>

            <p class="mb-4">Sala selecionada: <span x-text="selectedRoomId"></span></p>

            <input
                type="text"
                placeholder="Seu nome"
                x-model="userName"
                class="w-full px-3 py-2 mb-4 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />

            <div class="flex justify-end space-x-3">
                <button
                    @click="showModal = false"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                    Cancelar
                </button>
                <button
                    wire:loading.attr="disabled"
                    @click="
                        if(userName.trim() === '') {
                            alert('Por favor, digite seu nome.');
                            return;
                        }
                        $wire.joinRoom(selectedRoomId, userName).then(() => {
                            showModal = false;
                        })
                    "
                    class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700"
                >
                    Entrar
                </button>
            </div>
        </div>
    </div>
</div>
@script
    <script>
        Alpine.effect(() => {

            const channel = window.Echo.channel('refresh-rooms');

            channel.listen('.refresh-rooms', (data) => {
                Livewire.dispatch('refresh-rooms', {
                    data: data
                })
            });
        });
    </script>
@endscript
