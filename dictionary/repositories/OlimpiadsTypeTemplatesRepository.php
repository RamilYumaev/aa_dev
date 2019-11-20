<?php


namespace dictionary\repositories;


use dictionary\models\OlimpiadsTypeTemplates;

class OlimpiadsTypeTemplatesRepository
{
    public function get($id): OlimpiadsTypeTemplates
    {
        if (!$model = OlimpiadsTypeTemplates::findOne($id)) {
            throw new \DomainException('OlimpiadsTypeTemplates не найдено.');
        }
        return $model;
    }

    public function save(OlimpiadsTypeTemplates $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(OlimpiadsTypeTemplates $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}