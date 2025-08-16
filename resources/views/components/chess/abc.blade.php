<div class="absolute z-50 flex @if($userColor == 'branco') bottom-0 @endif">
    @foreach ($userColor == 'branco' ? $abc : array_reverse($abc, true) as $index => $item)
        <div
            @class([
                'flex w-square text-xs lg:text-base font-bold',
                'justify-end' => $userColor == 'branco',
                'justify-start pl-0.5' => $userColor == 'preto',
                'text-white' => $index%2 == 0,
            ])>
            {{ $item }}
        </div>
    @endforeach
</div>
