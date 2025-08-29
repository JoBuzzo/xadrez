<div class="flex flex-col w-full gap-2">
    <div class="flex flex-col items-center p-3 bg-white shadow-2xl rounded-xl">
        <span class="text-sm text-gray-500">Você</span>
        <span class="text-lg font-bold">{{ $user['name'] }}</span>
        @if ($user['turn'])
            <span
                class="inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&amp;&gt;svg]:size-3 gap-1 [&amp;&gt;svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden border-transparent [a&amp;]:hover:bg-primary/90 bg-blue-500 text-white hover:bg-blue-600 mt-2">
                Sua Vez
            </span>
        @endif
    </div>
    <div class="flex flex-col gap-6 p-3 text-gray-500 bg-white border shadow-2xl rounded-xl">
        <div class="space-y-2">
            <div class="flex items-center justify-between">
                <h4 class="text-sm font-medium">{{ $user['name'] }} - Capturadas</h4>
                <span class="text-xs text-gray-400">
                    +{{ count($user['capturedPieces']) }}
                </span>
            </div>
            <div class="flex flex-wrap gap-1">
                @forelse($user['capturedPieces'] as $capturedPiece)
                    <div class="flex items-center">
                        @php
                            $asset = "images/chess/pieces/$capturedPiece.png";
                        @endphp

                        <img src="{{ asset($asset) }}" alt="piece" class="size-5" />
                    </div>
                @empty
                    <p class="text-xs text-muted-foreground">Nenhuma peça capturada</p>
                @endforelse
            </div>
        </div>
    </div>
    <div class="flex flex-col gap-6 p-4 text-gray-500 bg-white border shadow-2xl rounded-xl">
        <div class="space-y-4">
            <h3 class="font-semibold">Histórico de Movimentos</h3>
            <div class="relative h-64">
                <div
                    class="focus-visible:ring-ring/50 size-full rounded-[inherit] transition-[color,box-shadow] outline-none focus-visible:ring-[3px] focus-visible:outline-1">
                    <div>
                        <div class="space-y-1">
                            @foreach ($history as $key => $historyItem)
                                <div class="grid items-center grid-cols-3 gap-2 text-sm">
                                    <span class="font-mono text-gray-400">
                                        {{ $key + 1 }}.
                                    </span>
                                    <button class="px-2 py-1 font-mono text-left rounded hover:bg-gray-100">
                                        {{ $historyItem }}
                                    </button>
                                    <button class="px-2 py-1 font-mono text-left rounded hover:bg-gray-100">
                                        {{ $historyItem }}
                                    </button>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            <div class="text-xs text-center text-gray-400">Movimento 2 de 2</div>
        </div>
    </div>
</div>
