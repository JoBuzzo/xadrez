<?php

namespace App\Services\Chess;

class GenerateBoardService
{
    public function __construct()
    {
        $this->generateBoard();
    }

    public function getBoard(): array
    {
        return $this->board;
    }
    private array $letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    private array $board = [];

    private array $pieces = [
        'whites' => [
            'white_rook',
            'white_knight',
            'white_bishop',
            'white_king',
            'white_queen',
            'white_pawn'
        ],
        'blacks' => [
            'black_rook',
            'black_knight',
            'black_bishop',
            'black_king',
            'black_queen',
            'black_pawn'
        ]
    ];

    private function generateBoard(): array
    {
        $count = count($this->letters);

        foreach ($this->letters as $value) {
            for ($i = 1; $i <= $count; $i++) {
                $this->board[$value . $i] = $value . $i;
            }
        }
        $this->positionPieces();

        return $this->board;
    }

    private function positionPieces(): void
    {
        for ($i = 0; $i <= count($this->pieces['whites']) - 1; $i++) {
            if ($i == 0) { //torre
                $this->board['a1'] = $this->pieces['whites'][$i];
                $this->board['h1'] = $this->pieces['whites'][$i];
            } elseif ($i == 1) { //cavalo
                $this->board['b1'] = $this->pieces['whites'][$i];
                $this->board['g1'] = $this->pieces['whites'][$i];
            } elseif ($i == 2) { //bispo
                $this->board['c1'] = $this->pieces['whites'][$i];
                $this->board['f1'] = $this->pieces['whites'][$i];
            } elseif ($i == 3) { // rei
                $this->board['e1'] = $this->pieces['whites'][$i];
            } elseif ($i == 4) { // rainha
                $this->board['d1'] = $this->pieces['whites'][$i];
            } else {
                for ($n = 0; $n <= count($this->letters) - 1; $n++) {
                    $this->board[$this->letters[$n] . '2'] = $this->pieces['whites'][$i];
                }
            }
        }

        for ($i = 0; $i <= count($this->pieces['blacks']) - 1; $i++) {
            if ($i == 0) { //torre
                $this->board['a8'] = $this->pieces['blacks'][$i];
                $this->board['h8'] = $this->pieces['blacks'][$i];
            } elseif ($i == 1) { //cavalo
                $this->board['b8'] = $this->pieces['blacks'][$i];
                $this->board['g8'] = $this->pieces['blacks'][$i];
            } elseif ($i == 2) { //bispo
                $this->board['c8'] = $this->pieces['blacks'][$i];
                $this->board['f8'] = $this->pieces['blacks'][$i];
            } elseif ($i == 3) { // rei
                $this->board['e8'] = $this->pieces['blacks'][$i];
            } elseif ($i == 4) { // rainha
                $this->board['d8'] = $this->pieces['blacks'][$i];
            } else {
                for ($n = 0; $n <= count($this->letters) - 1; $n++) {
                    $this->board[$this->letters[$n] . '7'] = $this->pieces['blacks'][$i];
                }
            }
        }
    }

}
