<div class="relative p-6 bg-white shadow-2xl rounded-xl">
    <div class="relative flex select-none">
        <x-chess.numbers :userColor="$userColor" />

        <x-chess.board-square :userColor="$userColor" :board="$board" :selectedPiece="$selectedPiece" :possibilities="$possibilities"
            :turn="$turn" />

        <x-chess.letters :userColor="$userColor" :letters="['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']" />
    </div>
</div>
