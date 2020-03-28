<?php


namespace modules\entrant\repositories;
use modules\entrant\models\ECP;

class ECPRepository
{
    public function get($id): ECP
    {
        if (!$model = ECP::findOne($id)) {
            throw new \DomainException('ЭЦП не найден.');
        }
        return $model;
    }

    public function save(ECP $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(ECP $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}