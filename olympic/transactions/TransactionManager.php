<?php
<<<<<<< HEAD:common/transactions/TransactionManager.php

namespace common\transactions;
=======
namespace olympic\transactions;
>>>>>>> #10:olympic/transactions/TransactionManager.php

class TransactionManager
{
    public function wrap(callable $function): void
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $function();
            $transaction->commit();
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}