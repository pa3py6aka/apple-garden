<?php

namespace core\Entity\query;

use core\Entity\User;
use yii\db\ActiveQuery;

class UserQuery extends ActiveQuery
{
    public function byStatus($status, $alias = null): UserQuery
    {
        return $this->andWhere([($alias ? "{$alias}." : '') . 'status' => $status]);
    }

    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null): ?User
    {
        return parent::one($db);
    }
}
