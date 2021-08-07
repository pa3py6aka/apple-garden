<?php

namespace core\Entity\query;

use core\Entity\Apple;
use yii\db\ActiveQuery;

class AppleQuery extends ActiveQuery
{
    public function byStatus($status, $alias = null): AppleQuery
    {
        return $this->andWhere([($alias ? "{$alias}." : '') . 'status' => $status]);
    }

    /**
     * {@inheritdoc}
     * @return Apple[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Apple|array|null
     */
    public function one($db = null): ?Apple
    {
        return parent::one($db);
    }
}
