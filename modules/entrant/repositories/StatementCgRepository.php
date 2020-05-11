<?php
namespace modules\entrant\repositories;

use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementCgRepository extends RepositoryDeleteSaveClass
{
    public function get($id): StatementCg
    {
        if (!$model = StatementCg::findOne($id)) {
            throw new \DomainException('Образоавтельная программа не найдена');
        }
        return $model;
    }

    public function getUser($id, $userId)
    {
        if (!$model = StatementCg::find()->alias('cg')->joinWith('statement')
            ->where(['cg.id' => $id, 'user_id' => $userId, 'status' => Statement::DRAFT])->one()) {
            throw new \DomainException('Образоавтельная программа не найдена.');
        }
        return $model;
    }

    public function getUserStatement($cg_id, $userId)
    {
        if (!$model = StatementCg::find()->alias('cg')->joinWith('statement')
            ->where(['cg_id' => $cg_id, 'user_id' => $userId])->one()) {
            return false;
        }
        return $model;
    }

}