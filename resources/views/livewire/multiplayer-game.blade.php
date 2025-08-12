<div>
    @if ($waitingForOpponent)
        <div class="flex items-center justify-center p-4 font-extrabold">
            <span>Aguardando o oponente...</span>
        </div>
    @else
        <div class="flex flex-col bg-[#c2bb9f] rounded-lg lg:mt-1 mt-16 relative">
            <div class="w-full lg:h-[75px] h-12 flex justify-center items-center lg:text-2xl font-extrabold px-4">
                <h1>Xadrez {{ $check ? 'Check' : '' }}</h1>
            </div>
            <div class="flex select-none">
                @php
                    $num = 0;
                    $colors = ['bg-black/70', 'bg-[#fbf5de]'];
                @endphp

                <div>
                    @if ($user['color'] == 'branco')

                        @for ($i = 8; $i >= 1; $i--)
                            <div
                                class="lg:w-[75px] lg:h-[75px] w-7 h-9 justify-center items-center flex lg:text-2xl font-extrabold">
                                {{ $i }}
                            </div>
                        @endfor
                    @else
                        @for ($i = 1; $i <= 8; $i++)
                            <div
                                class="lg:w-[75px] lg:h-[75px] w-7 h-9 justify-center items-center flex lg:text-2xl font-extrabold">
                                {{ $i }}
                            </div>
                        @endfor
                    @endif
                </div>

                <div class="flex flex-col">
                    <div class="transform rotate-[-90deg] lg:w-[600px] lg:h-[600px] shadow-2xl w-[288px] h-[288px]">
                        @foreach ($user['color'] == 'branco' ? $board : array_reverse($board) as $key => $box)
                            @php
                                $num++;

                                if ($num % 8 == 1) {
                                    $colors = array_reverse($colors);
                                }

                                $colorIndex = $num % 2;
                                $contrast =
                                    (array_key_exists('position', $selectedPiece) &&
                                        $selectedPiece['position'] == $key) ||
                                    (!empty($possibilities) && in_array($key, $possibilities));
                            @endphp

                            <div class="float-left lg:w-[75px] lg:h-[75px] w-9 h-9 text-gray-100 transform rotate-[90deg] flex justify-center items-center cursor-pointer
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
                        @foreach ($user['color'] == 'branco' ? $abc : array_reverse($abc) as $item)
                            <div
                                class="lg:w-[75px] lg:h-[75px] w-9 h-7 justify-center items-center flex lg:text-2xl font-extrabold uppercase">
                                {{ $item }}
                            </div>
                        @endforeach
                    </div>
                </div>

                <div
                    class="lg:w-[75px] w-7 lg:h-[600px] h-[288px] flex lg:text-lg font-extrabold justify-center
                    {{ $turn ? 'items-end' : 'items-start' }}
                ">
                    <div class="flex-col items-start justify-center hidden p-1 text-sm lg:flex">
                        <span>
                            @if ($turn)
                                Sua Vez
                            @else
                                Vez do Oponente
                            @endif
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-center p-1 text-sm font-extrabold lg:hidden">
                <span>
                    @if ($turn)
                        Sua Vez
                    @else
                        Vez do Oponente
                    @endif
                </span>
            </div>

            @if ($modal)
                <div class="absolute z-50 flex items-center justify-center w-full h-full">
                    <div class="flex flex-col items-center p-2 bg-gray-300 rounded-lg md:w-1/2 justify-evenly md:h-1/2">
                        <p class="text-lg font-bold">
                            Ao chegar na última casa o peão é promovido, substituído por uma rainha, ou
                            torre, ou bispo, ou cavalo
                            <br>
                            Por favor escolha uma das peças abaixo:
                        </p>
                        @php
                            $color = $user['color'] == 'branco' ? 'branco' : 'preta';
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

    @endif
</div>
