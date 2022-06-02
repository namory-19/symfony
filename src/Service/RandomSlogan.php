<?php

namespace App\Service;

class RandomSlogan
{
    public function getSlogan()
    {
        $arraySlogan =
            [
                "Think different",
                "Impossible is nothing",
                "Just do it",
                "Il est fou Afflelou, il est fou !",
                "Du soleil sur toute la ligne !",
                "Quand c’est trop, c’est Tropico !",
            ];
        $arrayRand = array_rand($arraySlogan, 2);
        $slogan = $arraySlogan[$arrayRand[0]] ?? null;
        return $slogan;
    }
}