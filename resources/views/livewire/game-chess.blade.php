<div class="flex flex-col bg-[#c2bb9f] rounded-lg mt-1">
    <div class="w-full h-[75px] flex justify-center items-center text-2xl font-extrabold px-4">
        <h1>Xadrez</h1>
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
</div>
