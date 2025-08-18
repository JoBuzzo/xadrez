<div class="absolute z-50 flex @if($userColor == 'white') bottom-0 @endif">
    @foreach ($userColor == 'white' ? $letters : array_reverse($letters, true) as $index => $item)
        <div
            @class([
                'flex w-square text-xs lg:text-base font-bold p-0.5',
                'justify-end' => $userColor == 'white',
                'justify-start' => $userColor == 'black',
                'text-[#E8EDF9]' => $index%2 == 0,
                'text-[#B7C0D8]' => $index%2 == 1,
            ])>
            {{ $item }}
        </div>
    @endforeach
</div>
