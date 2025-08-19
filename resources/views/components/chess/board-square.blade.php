@php
    $squareIndex = 0;
    $colors = ['bg-[#B7C0D8]', 'bg-[#E8EDF9]'];
    $board = $userColor == 'white' ? $board : array_reverse($board);
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

            $asset = "images/chess/pieces/$occupant.png";
            $isPiece = $occupant !== $position;
            $shouldPulse = $turn && (($userColor == 'black' && strstr($occupant, 'black')) || ($userColor == 'white' && strstr($occupant, 'white')));

        @endphp

        <div wire:click="handleSquareClick('{{ $position }}', '{{ $occupant }}')" @class([
            'float-left size-square transform rotate-[90deg] flex justify-center items-center cursor-pointer relative overflow-hidden',
            $colors[$colorIndex],
        ])>
            @if ($isSelectedPiece)
                <span class="absolute inset-0 bg-[#7B61FF] pointer-events-none opacity-50"></span>
            @elseif ($isPossibility)
                <span class="absolute bg-[#7B61FF] pointer-events-none size-6 rounded-full opacity-50 z-50"></span>
            @endif

            @if ($isPiece)
                <img src="{{ asset($asset) }}" alt="piece"
                @class([
                    'z-30 size-piece',
                    'animate-pulse' => $shouldPulse && !$selectedPiece,
                ])>
            @endif
        </div>
    @endforeach
</div>
