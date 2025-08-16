@php
    $squareIndex = 0;
    $colors = ['bg-gray-700', 'bg-yellow-100'];
    $board = $userColor == 'branco' ? $board : array_reverse($board);
@endphp

<div class="transform rotate-[-90deg] shadow-2xl size-board">
    @foreach ($board as $position => $occupant)
        @php
            $squareIndex++;

            if ($squareIndex % 8 == 1) {
                $colors = array_reverse($colors);
            }

            $colorIndex = $squareIndex % 2;

            $isSelectedPiece = array_key_exists('position', $selectedPiece) && $selectedPiece['position'] == $position;
            $isPossibility = !empty($possibilities) && in_array($position, $possibilities);

            $asset = "images/$occupant.png";
            $isPiece = $occupant !== $position;
            $shouldPulse = $turn && (($userColor == 'preto' && strstr($occupant, 'preta')) || ($userColor == 'branco' && strstr($occupant, 'branco')));

        @endphp

        <div wire:click="handleSquareClick('{{ $position }}', '{{ $occupant }}')" @class([
            'float-left size-square transform rotate-[90deg] flex justify-center items-center cursor-pointer relative overflow-hidden',
            $colors[$colorIndex],
        ])>
            @if ($isSelectedPiece)
                <span class="absolute inset-0 bg-green-900 pointer-events-none opacity-40"></span>
            @elseif ($isPossibility)
                <span class="absolute inset-0 bg-green-400 pointer-events-none opacity-30 animate-pulse"></span>
            @endif

            @if ($isPiece)
                <img src="{{ asset($asset) }}" alt="piece"
                @class([
                    'z-30',
                    'animate-pulse' => $shouldPulse && !$selectedPiece,
                ])>
            @endif
        </div>
    @endforeach
</div>
