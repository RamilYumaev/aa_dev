<?php
namespace testing\repositories;

use testing\models\TestAttempt;
use Yii;

class TestAttemptRepository
{
    public function get($id): TestAttempt
    {
        if (!$model = TestAttempt::findOne($id)) {
            throw new \DomainException( 'TestAttempt не найдено.');
        }
        return $model;
    }

    public function isAttempt($test_id): ? TestAttempt
    {
        return $model = TestAttempt::findOne(['test_id'=>$test_id, 'user_id'=> Yii::$app->user->identity->getId()]);
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