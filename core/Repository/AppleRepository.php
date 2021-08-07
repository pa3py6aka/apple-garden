<?php

namespace core\Repository;

use core\Entity\Apple;
use yii\web\NotFoundHttpException;

class AppleRepository
{
    /**
     * @throws NotFoundHttpException
     */
    public function getById($id): Apple
    {
        if (!$apple = Apple::find()->where(['id' => $id])->limit(1)->one()) {
            throw new NotFoundHttpException('Яблоко не найдено.');
        }

        return $apple;
    }

    /**
     * @return Apple[]|array
     */
    public function findByStatus($status): array
    {
        return Apple::find()->byStatus($status)->all();
    }

    public function save(Apple $apple): void
    {
        if (!$apple->save()) {
            throw new \RuntimeException('Ошибка сохранения яблока.');
        }
    }
}
