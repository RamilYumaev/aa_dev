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

    public function getNomination($test_id, $nomination): void
    {
        if (TestAttempt::find()->test($test_id)->andWhere(['nomination_id'=> $nomination])->exists()) {
            throw new \DomainException('Такая наминация есть у другого участника.');
        }
    }

    public function remove(TestAttempt $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }


}