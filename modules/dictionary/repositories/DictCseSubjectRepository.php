<?php


namespace modules\dictionary\repositories;
use modules\dictionary\models\DictCseSubject;

class DictCseSubjectRepository
{
    public function get($id): DictCseSubject
    {
        if (!$model = DictCseSubject::findOne($id)) {
            throw new \DomainException('Предмет не найден.');
        }
        return $model;
    }

    public function getForAis($aisId): ? DictCseSubject
    {
        return DictCseSubject::findOne(['ais_id'=> $aisId]);
    }

    public function save(DictCseSubject $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(DictCseSubject $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }

}