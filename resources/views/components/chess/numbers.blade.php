<div class="absolute z-50 @if ($userColor == 'black') right-0 @endif">
    @if ($userColor == 'white')

        @for ($i = 8; $i >= 1; $i--)
            <div @class([
                'flex h-square lg:text-base font-bold text-xs p-0.5',
                'items-end' => $userColor == 'black',
                'items-start' => $userColor == 'white',
                'text-[#E8EDF9]' => $i % 2 == 1,
                'text-[#B7C0D8]' => $i % 2 == 0,
            ])>
                {{ $i }}
            </div>
        @endfor
    @else
        @for ($i = 1; $i <= 8; $i++)
            <div @class([
                'flex h-square lg:text-base font-bold text-xs p-0.5',
                'items-end' => $userColor == 'black',
                'items-start' => $userColor == 'white',
                'text-[#E8EDF9]' => $i % 2 == 1,
                'text-[#B7C0D8]' => $i % 2 == 0,
            ])>
                {{ $i }}
            </div>
        @endfor
    @endif
</div>
