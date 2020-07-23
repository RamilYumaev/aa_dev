<?php

namespace modules\exam\readRepositories;

use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
use modules\exam\models\ExamStatement;
use modules\exam\models\ExamTest;
use testing\helpers\TestHelper;
use yii\data\Pagination;

class ExamTestReadRepository
{
    public function find($id)
    {
        if(($test = ExamTest::findOne(['id' => $id, 'status' => TestHelper::ACTIVE])) !== null) {
            return $test;
        }
        throw new \DomainException( 'Тест не найден.');
    }

    public function quentTests($id, $userId) {
        $testAttempt = $this->isAttempt($id, $userId);
        $this->isExamSuccess($testAttempt->user_id, $testAttempt->exam_id);
        if ($testAttempt->isAttemptEnd() || $testAttempt->end < date("Y-m-d H:i:s")) {
            throw new \DomainException('Ваша попытка прохождения теста закончена');
        }
        return ExamResult::find()->where(['attempt_id'=>$testAttempt->id])->orderBy(['priority'=> SORT_ASC]);
    }

    public function quentTestsCount($id, $userId) {
        return $this->quentTests($id, $userId)->count();
    }

    public function  pageCount ($id, $userId) {
        $pages = new Pagination(['totalCount' =>$this->quentTestsCount($id, $userId),
           'pageSize' => 1
        ]);
        return $pages;
    }

    public function  pageOffset ($id, $userId) {
        $que= $this->pageCount($id, $userId);
        return $this->quentTests($id, $userId)
            ->offset($que->offset)
            ->limit($que->limit)
            ->all();
    }

    public function isAttempt($id, $userId) {
        if(($testAttempt = ExamAttempt::findOne(['user_id'=> $userId,
            'test_id'=> $this->find($id)->id])) !== null) {
            return $testAttempt;
        }
        throw new \DomainException( 'Попытка не найдена.');
    }

    public function isExamSuccess($userId, $examId) {
        if((ExamStatement::findOne(['exam_id'=>$examId, 'status'=>ExamStatementHelper::SUCCESS_STATUS, 'entrant_user_id' =>$userId])) == null) {
            throw new \DomainException( 'Нет допуска к эказмену.');
        }

    }
}