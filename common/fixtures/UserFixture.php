<?php
namespace common\fixtures;

use yii\test\ActiveFixture;
use core\Entity\User;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}
