<?php


namespace dictionary\repositories;


use Codeception\Lib\Di;
use dictionary\models\DictDiscipline;

class DictDisciplineRepository
{

    public function get($id): DictDiscipline
    {
        if (!$model = DictDiscipline::findOne($id)) {
            throw new \DomainException('DictDiscipline не найдено.');
        }
        return $model;
    }

    public function getCse($cseId): ?DictDiscipline
    {
        return  DictDiscipline::findOne(['cse_subject_id' => $cseId]);
    }


    public function save(DictDiscipline $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictDiscipline $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}