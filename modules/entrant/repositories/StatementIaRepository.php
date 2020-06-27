<?php
namespace modules\entrant\repositories;

use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementIa;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementIaRepository extends RepositoryDeleteSaveClass
{
    public function get($id): StatementIa
    {
        if (!$model = StatementIa::findOne($id)) {
            throw new \DomainException('Индивидуальное достижение не найдено');
        }
        return $model;
    }

    public function getUser($id, $userId)
    {
        if (!$model = StatementIa::find()->alias('ia')->joinWith('statementIndividualAchievement')
            ->where(['individual_id' => $id, 'user_id' => $userId, 'status' => StatementIndividualAchievements::DRAFT])->one()) {
            throw new \DomainException('Индивидуальное достижение не найдено.');
        }
        return $model;
    }

    public function getUserStatement($individual_id, $userId)
    {
        if (!$model = StatementIa::find()->joinWith('statementIndividualAchievement')
            ->where(['individual_id' => $individual_id, 'user_id' => $userId])->one()) {
            return false;
        }
        return $model;
    }

}