<?php

namespace App\Enums;

enum Turn: string
{
    case WHITE = 'white';
    case BLACK = 'black';

    public static function getColor(string $turn): self
    {
        return match ($turn) {
            'white' => self::WHITE,
            'black' => self::BLACK,
        };
    }

    public static function isTurn(string $turn): bool
    {
        return self::getColor($turn) === self::WHITE;
    }
}
