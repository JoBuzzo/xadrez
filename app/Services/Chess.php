<?php

namespace App\Services;

class Chess
{
    public $board = [];

    public $abc = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h'];

    public $pieces = [
        'brancas' => [
            'torre_branco',
            'cavalo_branco',
            'bispo_branco',
            'rei_branco',
            'rainha_branco',
            'peao_branco'
        ],
        'pretas' => [
            'torre_preta',
            'cavalo_preta',
            'bispo_preta',
            'rei_preta',
            'rainha_preta',
            'peao_preta'
        ]
    ];

    public function generateBoard()
    {
        $count = count($this->abc);

        foreach ($this->abc as $value) {
            for ($i = 1; $i <= $count; $i++) {
                $this->board[$value . $i] = $value . $i;
            }
        }
        return $this->board;
    }

    public function positionPieces()
    {
        for ($i = 0; $i <= count($this->pieces['brancas']) - 1; $i++) {
            if ($i == 0) { //torre
                $this->board['a1'] = $this->pieces['brancas'][$i];
                $this->board['h1'] = $this->pieces['brancas'][$i];
            } elseif ($i == 1) { //cavalo
                $this->board['b1'] = $this->pieces['brancas'][$i];
                $this->board['g1'] = $this->pieces['brancas'][$i];
            }elseif($i == 2){ //bispo
                $this->board['c1'] = $this->pieces['brancas'][$i];
                $this->board['f1'] = $this->pieces['brancas'][$i];
            }elseif($i == 3){ // rei
                $this->board['e1'] = $this->pieces['brancas'][$i];
            }elseif($i == 4){ // rainha
                $this->board['d1'] = $this->pieces['brancas'][$i];
            }else {
                for($n = 0; $n <= count($this->abc) - 1; $n++) {
                    $this->board[$this->abc[$n].'2'] = $this->pieces['brancas'][$i];
                }
            }
        }

        for ($i = 0; $i <= count($this->pieces['pretas']) - 1; $i++) {
            if ($i == 0) { //torre
                $this->board['a8'] = $this->pieces['pretas'][$i];
                $this->board['h8'] = $this->pieces['pretas'][$i];
            } elseif ($i == 1) { //cavalo
                $this->board['b8'] = $this->pieces['pretas'][$i];
                $this->board['g8'] = $this->pieces['pretas'][$i];
            }elseif($i == 2){ //bispo
                $this->board['c8'] = $this->pieces['pretas'][$i];
                $this->board['f8'] = $this->pieces['pretas'][$i];
            }elseif($i == 3){ // rei
                $this->board['e8'] = $this->pieces['pretas'][$i];
            }elseif($i == 4){ // rainha
                $this->board['d8'] = $this->pieces['pretas'][$i];
            }else {
                for($n = 0; $n <= count($this->abc) - 1; $n++) {
                    $this->board[$this->abc[$n].'7'] = $this->pieces['pretas'][$i];
                }
            }
        }
    }
}
