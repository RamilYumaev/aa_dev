<?php


namespace dictionary\repositories;


use dictionary\models\DictSpecialTypeOlimpic;

class DictSpecialTypeOlimpicRepository
{
    public function get($id): DictSpecialTypeOlimpic
    {
        if (!$model = DictSpecialTypeOlimpic::findOne($id)) {
            throw new \DomainException( 'DictSpecialTypeOlimpic не найдено.');
        }
        return $model;
    }

    public function save(DictSpecialTypeOlimpic $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictSpecialTypeOlimpic $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}