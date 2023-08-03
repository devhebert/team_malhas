<?php

namespace Enum;

enum TypeProductEnum
{
    const JEANS = 1;
    const SWEATSHIRT = 2;
    const TACTEL = 3;
    const WOOL = 4;
    const COTTON = 5;
    const LEGGING = 6;
    const SOCIAL = 7;
    const REGATTA = 8;
    const LEATHER = 9;
    const LONG = 10;
    const SHORT = 11;

    public static function getTypeProductName(int $value): string
    {
        return match ($value) {
            self::JEANS      => 'JEANS',
            self::SWEATSHIRT => 'SWEATSHIRT',
            self::TACTEL     => 'TACTEL',
            self::WOOL       => 'WOOL',
            self::COTTON     => 'COTTON',
            self::LEGGING    => 'LEGGING',
            self::SOCIAL     => 'SOCIAL',
            self::REGATTA    => 'REGATTA',
            self::LEATHER    => 'LEATHER',
            self::LONG       => 'LONG',
            self::SHORT      => 'SHORT',
            default => 'Não encontrado',
        };
    }

    public static function showTypeProductName(string $value): string
    {
        return match ($value) {
            'JEANS'      => 'Jeans',
            'SWEATSHIRT' => 'Moletom',
            'TACTEL'     => 'Tactel',
            'WOOL'       => 'Lã',
            'COTTON'     => 'Algodão',
            'LEGGING'    => 'Legging',
            'SOCIAL'     => 'Social',
            'REGATTA'    => 'Regata',
            'LEATHER'    => 'Couro',
            'LONG'       => 'Longo',
            'SHORT'      => 'Curto',
            default      => 'Não encontrado',
        };
    }
}
