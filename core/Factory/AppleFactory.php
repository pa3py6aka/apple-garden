<?php

namespace core\Factory;

use core\Entity\Apple;
use core\Enum\AppleStatus;

class AppleFactory
{
    public static function create(
        string $color,
        int $birthDate
    ): Apple {
        $apple = new Apple();
        $apple->setColor($color);
        $apple->setBirthDate($birthDate);
        $apple->setSize(1);
        $apple->setStatus(AppleStatus::ON_TREE);

        return $apple;
    }
}
