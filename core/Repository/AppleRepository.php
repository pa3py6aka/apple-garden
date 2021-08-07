<?php

namespace core\Repository;

use core\Entity\Apple;
use core\Enum\AppleStatus;
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

    /**
     * @return Apple[]|array
     */
    public function findByCriteria(array $criteria): array
    {
        return Apple::find()->where($criteria)->all();
    }

    /**
     * Puts the rotten status to apples that have been lying on the ground for more than $seconds value
     * @param int $seconds
     */
    public function updateRottingStatus(int $seconds): void
    {
        Apple::updateAll(['status' => AppleStatus::ROTTEN], [
            'and',
            ['status' => AppleStatus::ON_GROUND],
            ['<', 'fall_date', time() - $seconds],
        ]);
    }

    public function save(Apple $apple): void
    {
        if (!$apple->save()) {
            throw new \RuntimeException('Ошибка сохранения яблока.');
        }
    }

    public function deleteAll(): void
    {
        Apple::deleteAll();
    }
}
