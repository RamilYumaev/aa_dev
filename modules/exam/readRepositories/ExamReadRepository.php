<?php

namespace modules\exam\readRepositories;

use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
use modules\exam\models\ExamTest;
use yii\data\Pagination;

class ExamReadRepository
{
    public function find($id)
    {
        if(($test = ExamTest::findOne($id)) !== null) {
            return $test;
        }
        throw new \DomainException( 'Тест не найден');
    }

    public function quentTests($id) {
        $testAttempt = $this->isAttempt($id);
        return ExamResult::find()->where(['attempt_id'=>$testAttempt->id])->orderBy(['priority'=> SORT_ASC]);
    }

    public function quentTestsCount($id) {
        return $this->quentTests($id)->count();
    }

    public function  pageCount ($id) {
        $pages = new Pagination(['totalCount' =>$this->quentTestsCount($id),
           'pageSize' => 1
        ]);
        return $pages;
    }

    public function  pageOffset ($id) {
        $que= $this->pageCount($id);
        return $this->quentTests($id)
            ->offset($que->offset)
            ->limit($que->limit)
            ->all();
    }

    public function isAttempt($id) {
        if(($testAttempt = ExamAttempt::findOne(['user_id'=> \Yii::$app->user->identity->getId(),
            'test_id'=> $this->find($id)->id])) !== null) {
            return $testAttempt;
        }
        throw new \DomainException( 'Тест не найден.');
    }
}