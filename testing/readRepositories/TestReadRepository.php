<?php

namespace testing\readRepositories;

use testing\helpers\TestHelper;
use testing\models\Test;
use testing\models\TestAttempt;
use testing\models\TestResult;
use yii\data\Pagination;

class TestReadRepository
{
    public function find($id)
    {
        if(($test = Test::findOne(['id' => $id, 'status' => TestHelper::ACTIVE])) !== null) {
            return $test;
        }
        throw new \DomainException( 'Тест не найден.');
    }


    public function quentTests($id) {
        $testAttempt = $this->isAttempt($id);
        if ($testAttempt->end < date("Y-m-d H:i:s")) {
            throw new \DomainException('Ваша попытка прохождения теста закончена');
        }

        return TestResult::find()->where(['attempt_id'=>$testAttempt->id])->orderBy(['priority'=> SORT_ASC]);
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
        if(($testAttempt = TestAttempt::findOne(['user_id'=> \Yii::$app->user->identity->getId(),
            'test_id'=> $this->find($id)->id])) !== null) {
            return $testAttempt;
        }
        throw new \DomainException( 'Тест не найден.');
    }
}