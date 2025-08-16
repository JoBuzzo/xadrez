<div class="absolute z-50 @if($userColor == 'preto') right-0 @endif">
    @if ($userColor == 'branco')

        @for ($i = 8; $i >= 1; $i--)
            <div
                @class([
                    'flex h-square lg:text-base font-bold text-xs',
                    'items-end' => $userColor == 'preto',
                    'items-start' => $userColor == 'branco',
                    'text-white' => $i%2 == 1,
                ])>
                {{ $i }}
            </div>
        @endfor
    @else
        @for ($i = 1; $i <= 8; $i++)
            <div
                @class([
                    'flex h-square lg:text-base font-bold text-xs',
                    'items-end' => $userColor == 'preto',
                    'items-start' => $userColor == 'branco',
                    'text-white' => $i%2 == 1,
                ])>
                {{ $i }}
            </div>
        @endfor
    @endif
</div>
