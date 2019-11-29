<?php


namespace testing\services;


use common\transactions\TransactionManager;
use testing\forms\question\TestQuestionClozeForm;
use testing\forms\question\TestQuestionEditForm;
use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionTypesFileForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use testing\models\Answer;
use testing\models\AnswerCloze;
use testing\models\QuestionProposition;
use testing\models\Test;
use testing\models\TestQuestion;
use testing\repositories\AnswerClozeRepository;
use testing\repositories\AnswerRepository;
use testing\repositories\QuestionPropositionRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestQuestionRepository;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class QuestionConsoleService {
    private $repository;

    public function __construct(TestQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create()
    {
        foreach(Test::find()->all() as $test) {
            foreach (TestQuestion::find()->where(['test_id'=>$test->id])->all() as $q) {
                $qi =  $this->repository->get($q->id);
                $qi->olympic_id = $test->olimpic_id;
                $this->repository->save($qi);
            }
        }
    }

}