<?php

namespace core\Enum;


class AppleStatus
{
    public const ON_TREE = 1;
    public const ON_GROUND = 2;
    public const ROTTEN = 3;

    public static function getArray(): array
    {
        return [
            self::ON_TREE => 'На дереве',
            self::ON_GROUND => 'Упало',
            self::ROTTEN => 'Сгнило'
        ];
    }
}
