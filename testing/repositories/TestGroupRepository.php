<?php
namespace testing\repositories;

use testing\models\TestGroup;

class TestGroupRepository
{
    public function get($id): TestGroup
    {
        if (!$model = TestGroup::findOne($id)) {
            throw new \DomainException( 'TestGroup не найдено.');
        }
        return $model;
    }

    public function getIdAndTest($id, $test_id): TestGroup
    {
        if (!$model = TestGroup::findOne(['id' =>$id, 'test_id'=> $test_id ])) {
            throw new \DomainException( 'Группа вопросо данного теста не найдено.');
        }
        return $model;
    }

    public function save(TestGroup $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestGroup $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}