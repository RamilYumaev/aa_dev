<?php


namespace olympic\repositories;


use olympic\models\PersonalPresenceAttempt;

class PersonalPresenceAttemptRepository
{
    public function get($id): PersonalPresenceAttempt
    {
        if (!$model = PersonalPresenceAttempt::findOne($id)) {
            throw new \DomainException('PersonalPresenceAttempt не найдено.');
        }
        return $model;
    }

    public function getUser($olympic_id, $user_id): bool
    {
        PersonalPresenceAttempt::find()->olympic($olympic_id)->user($user_id)->exists();
    }

    public function getOlympic($olympic_id): void
    {
        if (PersonalPresenceAttempt::find()->olympic($olympic_id)->exists()) {
            throw new \DomainException('Такая ведомость существует.');
        }
    }

    public function getNomination($olympic_id, $nomination): void
    {
        if (PersonalPresenceAttempt::find()->olympic($olympic_id)->andWhere(['nomination_id'=> $nomination])->exists()) {
            throw new \DomainException('Такая наминация есть у другого участника.');
        }
    }

    public function save(PersonalPresenceAttempt $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(PersonalPresenceAttempt $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}