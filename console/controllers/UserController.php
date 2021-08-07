<?php

namespace console\controllers;

use core\Entity\User;
use core\Enum\UserStatus;
use core\Factory\UserFactory;
use yii\console\Controller;
use yii\console\Exception;
use yii\helpers\Console;


class UserController extends Controller
{
    /**
     * This action needs to set new password for any User
     * @throws Exception
     */
    public function actionSetPassword(): void
    {
        $email = $this->prompt('Email:', ['required' => true]);
        $password = $this->prompt('Password:', ['required' => true, 'validator' => function($input, &$error) {
            if (strlen($input) < 6) {
                $error = 'The Password must be at least 6 chars!';
                return false;
            }
            return true;
        }]);
        $user = $this->findModel($email);
        $user->setPassword($password);
        $user->save();
        $this->stdout('Done!' . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * Create new User
     */
    public function actionCreate(): void
    {
        $username = $this->prompt('Username:', ['required' => true]);
        $email = $this->prompt('Email:', ['required' => true]);
        $password = $this->prompt('Password:', ['required' => true, 'validator' => function($input, &$error) {
            if (strlen($input) < 6) {
                $error = 'The Password must be at least 6 chars!';
                return false;
            }
            return true;
        }]);
        $status = $this->select('Status:', UserStatus::getArray());

        $user = UserFactory::create($username, $email, $password);
        $user->status = $status;

        $user->save();
        $this->stdout("User created. ID: {$user->id}" . PHP_EOL, Console::FG_GREEN);
    }

    /**
     * @param string $email
     * @return User the loaded model
     *@throws Exception
     */
    private function findModel(string $email): User
    {
        if (!$model = User::findOne(['email' => $email])) {
            throw new Exception('User is not found');
        }
        return $model;
    }
}
