<?php


namespace common\sending\repositories;


use common\sending\models\SendingDeliveryStatus;

class SendingDeliveryStatusRepository
{
    public function get($id): SendingDeliveryStatus
    {
        if (!$model = SendingDeliveryStatus::findOne($id)) {
            throw new \DomainException( 'DSendingDeliveryStatus не найдено.');
        }
        return $model;
    }

    public function getHash($id, $hash): SendingDeliveryStatus
    {
        if (!$model = SendingDeliveryStatus::findOne(['id' => $id, 'hash' => $hash])) {
            throw new \DomainException( 'Такого письма не найдено.');
        }
        return $model;
    }

    public function getExits($userId, $type, $value, $typeSending):  bool
    {
        return  SendingDeliveryStatus::find()->user($userId)
            ->type($type)->value($value)->typeSending($typeSending)->exists();
    }

    public function save(SendingDeliveryStatus $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(SendingDeliveryStatus $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}