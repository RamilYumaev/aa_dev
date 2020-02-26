<?php


namespace modules\entrant\repositories;
use modules\entrant\models\Address;

class AddressRepository
{
    public function get($id): Address
    {
        if (!$model = Address::findOne($id)) {
            throw new \DomainException('Адрес не найден.');
        }
        return $model;
    }

    public function save(Address $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Address $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}