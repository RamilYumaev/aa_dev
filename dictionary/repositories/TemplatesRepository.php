<?php


namespace dictionary\repositories;


use dictionary\models\Templates;

class TemplatesRepository
{
    public function get($id): Templates
    {
        if (!$model = Templates::findOne($id)) {
            throw new \DomainException( 'Templates не найдено.');
        }
        return $model;
    }

    public function save(Templates $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Templates $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}