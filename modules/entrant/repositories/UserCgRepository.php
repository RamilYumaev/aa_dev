<?php


namespace modules\entrant\repositories;


use modules\entrant\models\UserCg;

class UserCgRepository
{
    public function get($cgId): UserCg
    {
        if (!$model = UserCg::findOne(["user_id" => \Yii::$app->user->id, "cg_id" => $cgId])) {
            throw new \DomainException('Заявление уже удалено!');
        }
        return $model;
    }

    public function getUser($cgId, $userId): UserCg
    {
        if (!$model = UserCg::findOne(["user_id" => $userId, "cg_id" => $cgId])) {
            throw new \DomainException('Заявление уже удалено!');
        }
        return $model;
    }


    public function save(UserCg $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка в процессе сохранения.');
        }
    }

    public function remove(UserCg $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка в процессе удаления.');
        }
    }

    public function haveARecord($id)
    {
        $model = UserCg::find()->findUserAndCg($id)->exists();
        if ($model) {
            throw new \DomainException('Заявление добавлено!');
        }
    }

    public function haveARecordSpecialRight($id)
    {
        return UserCg::find()->findUserAndCg($id)->exists();
    }

}