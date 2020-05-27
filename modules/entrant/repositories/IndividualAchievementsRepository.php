<?php

namespace modules\entrant\repositories;
use modules\entrant\models\UserIndividualAchievements;
use modules\usecase\RepositoryDeleteSaveClass;

class IndividualAchievementsRepository extends RepositoryDeleteSaveClass
{
    public function get($id): UserIndividualAchievements
    {
        if (!$model =  UserIndividualAchievements::findOne($id)) {
            throw new \DomainException('Индивидуальное достижение не найдено.');
        }
        return $model;
    }

    public function isIndividual($userId, $individualId): void
    {
        if ($model = UserIndividualAchievements::findOne(['individual_id' =>$individualId, 'user_id' => $userId])) {
            throw new \DomainException('Такое индивидуальное достижение существует.');
        }
    }


}