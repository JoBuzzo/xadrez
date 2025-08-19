@if ($promotionModal)
    @php
        $queenAsset = "images/chess/pieces/{$color}_queen.png";
        $rookAsset = "images/chess/pieces/{$color}_rook.png";
        $bishopAsset = "images/chess/pieces/{$color}_bishop.png";
        $knightAsset = "images/chess/pieces/{$color}_knight.png";
    @endphp

    <!-- Fundo escuro -->
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <!-- Conteúdo do modal -->
        <div class="flex flex-col items-center justify-between p-6 bg-white rounded-2xl shadow-2xl w-[95%] max-w-md animate-fade-in">

            <!-- Título -->
            <p class="mb-4 text-xl font-bold text-center text-gray-800">
                Promoção de Peão ♟️
            </p>

            <p class="mb-6 text-sm text-center text-gray-600">
                Seu peão chegou na última casa.
                Escolha a peça para substituí-lo:
            </p>

            <!-- Peças -->
            <div class="flex items-center justify-center gap-6">
                <button wire:click='replacePawn("queen")' class="transition-transform hover:scale-110">
                    <img src="{{ asset($queenAsset) }}" alt="Rainha" class="w-14 h-14 md:w-20 md:h-20">
                </button>
                <button wire:click='replacePawn("rook")' class="transition-transform hover:scale-110">
                    <img src="{{ asset($rookAsset) }}" alt="Torre" class="w-14 h-14 md:w-20 md:h-20">
                </button>
                <button wire:click='replacePawn("bishop")' class="transition-transform hover:scale-110">
                    <img src="{{ asset($bishopAsset) }}" alt="Bispo" class="w-14 h-14 md:w-20 md:h-20">
                </button>
                <button wire:click='replacePawn("knight")' class="transition-transform hover:scale-110">
                    <img src="{{ asset($knightAsset) }}" alt="Cavalo" class="w-14 h-14 md:w-20 md:h-20">
                </button>
            </div>
        </div>
    </div>
@endif
