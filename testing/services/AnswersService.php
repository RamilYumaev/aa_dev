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
use testing\models\TestQuestion;
use testing\repositories\AnswerClozeRepository;
use testing\repositories\AnswerRepository;
use testing\repositories\QuestionPropositionRepository;
use testing\repositories\TestQuestionGroupRepository;
use testing\repositories\TestQuestionRepository;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class AnswersService {
    private $repository;
    private $transaction;
    private $answerRepository;

    public function __construct(TestQuestionRepository $repository,
                                TransactionManager $transaction,
                                AnswerRepository $answerRepository)
    {
        $this->repository = $repository;
        $this->transaction = $transaction;
        $this->answerRepository = $answerRepository;
    }

    public function create()
    {
        $type = [TestQuestionHelper::TYPE_ANSWER_SHORT,
            TestQuestionHelper::TYPE_SELECT_ONE,
            TestQuestionHelper::TYPE_SELECT,
            TestQuestionHelper::TYPE_MATCHING];
        $model = TestQuestion::find()->andWhere(['type_id'=>$type]);
        $this->transaction->wrap(function () use ($model) {
            foreach ($model->all() as $question) {
                $options = Json::decode($question->options);
                if ($options) {
                    $this->addAnswer($options, $question->type_id, $question->id);
                }
            }
        });
        return $model;
    }

    private function addAnswerSelect($options, $quest_id) {
        foreach ($options['text'] as $index => $answer) {
            if ($answer === '') continue;
            $isCorrect = in_array($index, $options['isCorrect']) ? 1 : 0;
            $answerObject = Answer::create($quest_id, $answer, $isCorrect, null);
            $this->answerRepository->save($answerObject);
        }
    }

    private function addAnswerSort($options, $quest_id) {
        foreach ($options as $index => $answer) {
            if ($answer === '') continue;
            $answerObject = Answer::create($quest_id, $answer, 1, null);
            $this->answerRepository->save($answerObject);
        }
    }

    private function addAnswerMatching($options, $quest_id) {
        foreach ($options['option'] as $index =>  $answerMatch) {
            if ($answerMatch  === '') continue;
            $answer = $options['text'][$index];
            $isCorrect = $options['text'][$index] ? 1 : 0;
            $answerObject = Answer::create($quest_id, $answer, $isCorrect, $answerMatch);
            $this->answerRepository->save($answerObject);
        }
    }

    private function addAnswer($options, $type_id, $quest_id) {
        if ($type_id === TestQuestionHelper::TYPE_SELECT || $type_id ===  TestQuestionHelper::TYPE_SELECT_ONE) {
            $this->addAnswerSelect($options, $quest_id);
        } else if ($type_id === TestQuestionHelper::TYPE_ANSWER_SHORT) {
            $this->addAnswerSort($options, $quest_id);
        } else if ($type_id === TestQuestionHelper::TYPE_MATCHING) {
            $this->addAnswerMatching($options, $quest_id);
        }
    }


}