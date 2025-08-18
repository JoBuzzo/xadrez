<?php

namespace App\Services\Chess\GameMatch\Multiplayer\DTO;

class SelectedPieceDTO
{
    public function __construct(
        public ?string $position = null,
        public ?string $piece = null,
    )
    {
        //
    }

    public static function fromSquareClick(string $position, string $piece): SelectedPieceDTO
    {
        return new self(
            position: $position,
            piece: $piece,
        );
    }

    public function toArray():array
    {
        return [
            'position' => $this->position,
            'piece' => $this->piece,
        ];
    }

}
