@if ($modal)

    @php
        $queenAsset = "images/rainha_$color.png";
        $rookAsset = "images/torre_$color.png";
        $bishopAsset = "images/bispo_$color.png";
        $knightAsset = "images/cavalo_$color.png";
    @endphp

    <div class="absolute z-50 flex items-center justify-center w-full h-full">
        <div class="flex flex-col items-center p-2 bg-gray-300 rounded-lg md:w-1/2 justify-evenly md:h-1/2">
            <p class="text-lg font-bold">
                Ao chegar na última casa o peão é promovido, substituído por uma rainha, ou
                torre, ou bispo, ou cavalo
                <br>
                Por favor escolha uma das peças abaixo:
            </p>

            <div class="flex items-center justify-center">
                <button wire:click='replacePawn("rainha")'>
                    <img src="{{ asset($queenAsset) }}" alt="queen piece">
                </button>
                <button wire:click='replacePawn("torre")'>
                    <img src="{{ asset($rookAsset) }}" alt="rook piece">
                </button>
                <button wire:click='replacePawn("bispo")'>
                    <img src="{{ asset($bishopAsset) }}" alt="bishop piece">
                </button>
                <button wire:click='replacePawn("cavalo")'>
                    <img src="{{ asset($knightAsset) }}" alt="knight piece">
                </button>
            </div>
        </div>
    </div>
@endif
