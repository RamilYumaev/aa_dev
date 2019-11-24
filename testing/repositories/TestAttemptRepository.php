<?php
namespace testing\repositories;

use testing\models\TestAttempt;

class TestAttemptRepository
{
    public function get($id): TestAttempt
    {
        if (!$model = TestAttempt::findOne($id)) {
            throw new \DomainException( 'TestAttempt не найдено.');
        }
        return $model;
    }

    public function save(TestAttempt $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestAttempt $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}