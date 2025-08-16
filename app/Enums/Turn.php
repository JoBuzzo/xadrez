<?php

namespace App\Enums;

enum Turn: string
{
    case WHITE = 'branco';
    case BLACK = 'preto';

    public static function getColor(string $turn): self
    {
        return match ($turn) {
            'branco' => self::WHITE,
            'preto' => self::BLACK,
        };
    }

    public static function isTurn(string $turn): bool
    {
        return self::getColor($turn) === self::WHITE;
    }
}
