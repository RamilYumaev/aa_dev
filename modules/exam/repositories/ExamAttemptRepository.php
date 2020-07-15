<?php


namespace modules\exam\repositories;

use modules\exam\models\ExamAttempt;
use modules\usecase\RepositoryDeleteSaveClass;
use Yii;

class ExamAttemptRepository extends RepositoryDeleteSaveClass
{
    public function get($id): ExamAttempt
    {
        if (!$model = ExamAttempt::findOne($id)) {
            throw new \DomainException('Попытка не найдена');
        }
        return $model;
    }

    public function isAttempt($test_id): ? ExamAttempt
    {
        return $model = ExamAttempt::findOne(['test_id'=>$test_id, 'user_id'=> Yii::$app->user->identity->getId()]);
    }

    public function isAttemptTest($test_id): bool
    {
        return $model = ExamAttempt::find()->andWhere(['test_id'=>$test_id ])->exists();
    }

}