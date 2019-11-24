<?php
namespace testing\repositories;

use testing\models\TestClass;

class TestClassRepository
{
    public function get($test_id, $class_id): TestClass
    {
        if (!$model = TestClass::findOne(['test_id' => $test_id, 'class_id' => $class_id])) {
            throw new \DomainException( 'TestClass не найдено.');
        }
        return $model;
    }

    public function isTestClass($test_id, $class_id): void
    {
        if ($model = TestClass::findOne(['test_id' => $test_id, 'class_id' => $class_id])) {
            throw new \DomainException('Класс(-ы) для такого теста существует(-ют)');
        }
    }

    public function save(TestClass $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TestClass $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}