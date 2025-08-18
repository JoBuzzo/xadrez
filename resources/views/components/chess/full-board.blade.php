<div class="p-6 bg-[#8B5E3C] rounded-xl shadow-2xl relative">
    <div class="relative flex select-none">
        <x-chess.numbers :userColor="$userColor" />

        <x-chess.board-square :userColor="$userColor" :board="$board" :selectedPiece="$selectedPiece" :possibilities="$possibilities"
            :turn="$turn" />

        <x-chess.abc :userColor="$userColor" :abc="['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h']" />
    </div>
</div>
