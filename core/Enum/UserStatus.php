<?php

namespace core\Enum;


class UserStatus
{
    public const STATUS_INACTIVE = 9;
    public const STATUS_DELETED = 0;
    public const STATUS_ACTIVE = 10;

    public static function getArray(): array
    {
        return [
            self::STATUS_INACTIVE => 'Неактивен',
            self::STATUS_DELETED => 'Удалён',
            self::STATUS_ACTIVE => 'Активен'
        ];
    }
}
