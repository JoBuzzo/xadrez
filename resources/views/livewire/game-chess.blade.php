<div class="flex flex-col bg-[#c2bb9f] rounded-lg mt-1 relative">
    <div class="w-full h-[75px] flex justify-center items-center text-2xl font-extrabold px-4">
        <h1>Xadrez {{ $check ? 'Check' : ''}}</h1>
    </div>
    <div class="flex select-none">
        @php
            $num = 0;
            $colors = ['bg-black/70', 'bg-[#fbf5de]'];
        @endphp

        <div>
            @for ($i = 8; $i >= 1; $i--)
                <div class="w-[75px] h-[75px] justify-center items-center flex text-2xl font-extrabold">
                    {{ $i }}
                </div>
            @endfor
        </div>

        <div class="flex flex-col">
            <div class="transform rotate-[-90deg] w-[600px] h-[600px] shadow-2xl">
                @foreach ($board as $key => $box)
                    @php
                        $num++;

                        if ($num % 8 == 1) {
                            $colors = array_reverse($colors);
                        }

                        $colorIndex = $num % 2;
                        $contrast = (array_key_exists('position', $selectedPiece) && $selectedPiece['position'] == $key) || (!empty($possibilities) && in_array($key, $possibilities));
                    @endphp

                    <div class="float-left w-[75px] h-[75px] text-gray-400 transform rotate-[90deg] flex justify-center items-center cursor-pointer 
                        {{ $colors[$colorIndex] }}
                        {{ $contrast ? ' contrast-50' : '' }}"
                        wire:click="move('{{ $key }}', '{{ $box }}')">
                        @if (strstr($box, 'preta') || strstr($box, 'branco'))
                            <img src="{{ asset("images/$box.png") }}" alt="piece">
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="flex">
                @foreach ($abc as $item)
                    <div class="w-[75px] h-[75px] justify-center items-center flex text-2xl font-extrabold uppercase">
                        {{ $item }}
                    </div>
                @endforeach
            </div>
        </div>

        <div
            class="w-[75px] h-[600px] flex text-lg font-extrabold justify-center
            {{ $turn ? 'items-end' : 'items-start' }}
            ">
            <div class="flex flex-col items-start justify-center p-1">
                <span>
                    @if ($turn)
                        Brancas
                    @else
                        Pretas
                    @endif
                </span>
                <span>Jogam</span>
            </div>
        </div>
    </div>

    @if ($modal)
        <div class="absolute z-50 flex items-center justify-center w-full h-full">
            <div class="flex flex-col items-center w-1/2 p-2 bg-gray-300 rounded-lg justify-evenly h-1/2">
                <p class="text-lg font-bold">
                    Ao chegar na última casa o peão é promovido, substituído por uma rainha, ou
                    torre, ou bispo, ou cavalo
                    <br>
                    Por favor escolha uma das peças abaixo:
                </p>
                @php
                    $color = $this->turn ? 'branco' : 'preta';
                @endphp
                <div class="flex items-center justify-center">
                    <button wire:click='replacePawn("rainha")'>
                        <img src="{{ asset("images/rainha_$color.png") }}" alt="piece">
                    </button>
                    <button wire:click='replacePawn("torre")'>
                        <img src="{{ asset("images/torre_$color.png") }}" alt="piece">
                    </button>
                    <button wire:click='replacePawn("bispo")'>
                        <img src="{{ asset("images/bispo_$color.png") }}" alt="piece">
                    </button>
                    <button wire:click='replacePawn("cavalo")'>
                        <img src="{{ asset("images/cavalo_$color.png") }}" alt="piece">
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
