<?php


namespace dictionary\repositories;


use dictionary\models\DictChairmans;

class DictChairmansRepository
{
    public function get($id): DictChairmans
    {
        if (!$model = DictChairmans::findOne($id)) {
            throw new \DomainException( 'DictChairmans не найдено.');
        }
        return $model;
    }

    public function save(DictChairmans $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictChairmans $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}