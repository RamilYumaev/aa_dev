<?php
namespace testing\repositories;

use testing\helpers\TestHelper;
use testing\models\Test;
use testing\models\TestClass;

class TestRepository
{
    public function get($id): Test
    {
        if (!$model = Test::findOne($id)) {
            throw new \DomainException( 'Test не найдено.');
        }
        return $model;
    }

    public function isActive($id): Test
    {
        if (!$model = Test::findOne(['id' => $id, 'status' => TestHelper::ACTIVE])) {
            throw new \DomainException( 'Такого теста не найдено.');
        }
        return $model;
    }

    public function isTestClass($olympic_id, $class_id): void
    {
        $model = Test::find()
            ->alias('t')
            ->innerJoin(TestClass::tableName() . ' tc', 'tc.test_id = t.id')
            ->andWhere(['t.olimpic_id' => $olympic_id])
            ->andWhere(['tc.class_id' => $class_id])
            ->one();

        if ($model) {
            throw new \DomainException('Класс(-ы) для такого теста существует(-ют)');
        }
    }

    public function save(Test $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Test $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}