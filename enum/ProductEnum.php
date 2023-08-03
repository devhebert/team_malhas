<?php

namespace Enum;

enum ProductEnum
{
    const PANTS = 1;
    const BLOUSE = 2;
    const SHIRT = 3;
    const DRESS = 4;
    const SHORTS = 5;
    const JACKET = 6;

    public static function getProductName(int $value): string
    {
        return match ($value) {
            self::PANTS  => 'PANTS',
            self::BLOUSE => 'BLOUSE',
            self::SHIRT  => 'SHIRT',
            self::DRESS  => 'DRESS',
            self::SHORTS => 'SHORTS',
            self::JACKET => 'JACKET',
            default      => 'Não encontrado',
        };
    }

    public static function showProductName(string $value): string
    {
        return match ($value) {
            'PANTS'  => 'Calça',
            'BLOUSE' => 'Blusa',
            'SHIRT'  => 'Camisa',
            'DRESS'  => 'Vestido',
            'SHORTS' => 'Shorts',
            'JACKET' => 'Jaqueta',
            default  => 'Não encontrado',
        };
    }
}
