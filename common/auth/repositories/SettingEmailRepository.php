<?php

namespace common\auth\repositories;

use common\auth\models\SettingEmail;

class SettingEmailRepository
{
    public function findBySettingEmail(): ?SettingEmail
    {
        return SettingEmail::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
    }

    public function save(SettingEmail $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(SettingEmail $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}