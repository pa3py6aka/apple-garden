<?php

namespace core\Service;

class TransactionManager
{
    /**
     * @throws \yii\db\Exception
     * @noinspection NullPointerExceptionInspection
     */
    public function wrap(callable $function): void
    {
        $transaction = \Yii::$app->db->beginTransaction(\yii\db\Transaction::REPEATABLE_READ);
        try {
            $function();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
