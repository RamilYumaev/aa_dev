<?php


namespace modules\entrant\repositories;

use modules\entrant\models\StatementIndividualAchievements;
use modules\usecase\RepositoryDeleteSaveClass;

class StatementIndividualAchievementsRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ?StatementIndividualAchievements
    {
        if (!$model = StatementIndividualAchievements::findOne($id)) {
            throw new \DomainException('Заявление не найдено!');
        }
        return  $model;
    }

    public function getStatementIAFull($userId, $eduLevel)
    {
        if (!$model = StatementIndividualAchievements::find()->user($userId)->defaultWhere($eduLevel,
            StatementIndividualAchievements::DRAFT)->one()) {
            return false;
        }
        return  $model;
    }

}