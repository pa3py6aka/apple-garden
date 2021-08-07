<?php

namespace core\Factory;

use core\Entity\User;
use core\Enum\UserStatus;

class UserFactory
{
    public static function create(string $username, string $email, string $password): User
    {
        $user = new User();
        $user->email = $email;
        $user->username = $username;
        $user->status = UserStatus::STATUS_INACTIVE;
        $user->generateAuthKey();
        $user->setPassword($password);

        return $user;
    }
}
