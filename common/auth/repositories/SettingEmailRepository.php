<?php

namespace common\auth\repositories;

use common\auth\models\SettingEmail;

class SettingEmailRepository
{
    public function findBySettingEmail(): ?SettingEmail
    {
        return SettingEmail::findOne(['user_id'=> \Yii::$app->user->identity->getId()]);
    }

    public function get($id): SettingEmail
    {
        if (!$model = SettingEmail::findOne($id)) {
            throw new \DomainException( 'Данные настройки для рассылок не найдено.');
        }
        return $model;
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