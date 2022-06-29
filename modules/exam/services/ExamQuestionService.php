<?php
namespace modules\exam\services;


use common\transactions\TransactionManager;
use modules\exam\forms\question\ExamQuestionForm;
use modules\exam\forms\question\ExamQuestionNestedCreateForm;
use modules\exam\forms\question\ExamQuestionNestedUpdateForm;
use modules\exam\forms\question\ExamTypeQuestionAnswerForm;
use modules\exam\models\ExamAnswer;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionNested;
use modules\exam\repositories\ExamAnswerNestedRepository;
use modules\exam\repositories\ExamAnswerRepository;
use modules\exam\repositories\ExamQuestionGroupRepository;
use modules\exam\repositories\ExamQuestionNestedRepository;
use modules\exam\repositories\ExamQuestionRepository;
use testing\helpers\TestQuestionHelper;
use yii\helpers\ArrayHelper;

class ExamQuestionService
{
    private $repository;
    private $answerNestedRepository, $questionGroupRepository,
        $answerRepository, $questionNestedRepository;
    private $transactionManager;

    public function __construct(ExamQuestionRepository $repository,
                                ExamAnswerNestedRepository $answerNestedRepository,
                                ExamQuestionGroupRepository $questionGroupRepository,
                                ExamAnswerRepository $answerRepository,
                                ExamQuestionNestedRepository $questionNestedRepository,
                                TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->answerNestedRepository = $answerNestedRepository;
        $this->answerRepository= $answerRepository;
        $this->questionGroupRepository = $questionGroupRepository;
        $this->questionNestedRepository = $questionNestedRepository;
    }

    public function create(ExamQuestionForm $form)
    {
        $this->isQuestionGroup($form->question_group_id);
        $model  = ExamQuestion::create($form);
        $this->repository->save($model);
        return $model;
    }



    public function edit($id, ExamQuestionForm $form)
    {
        $this->isQuestionGroup($form->question_group_id);
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    private function isQuestionGroup($group){
        if ($group) {
            $this->questionGroupRepository->get($group);
        }
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    public function createAnswer(ExamTypeQuestionAnswerForm $form)
    {;
        $this->transactionManager->wrap(function () use ($form) {
            $model = $this->create($form->question);
            $this->addAnswer($form, $model->type_id, $model->id);
        });
    }

    public function editAnswer($id, ExamTypeQuestionAnswerForm $form)
    {
        $question = $this->repository->get($id);

        $this->transactionManager->wrap(function () use ($question, $form) {
            $this->edit($question->id, $form->question);
            $this->updateAnswer($form, $question->type_id, $question->id);
        });
    }


    private function addAnswerSelect(ExamTypeQuestionAnswerForm $form, $quest_id) {
        foreach ($form->answer as $index => $answer) {
            $answerObject = ExamAnswer::create($quest_id, $answer->name, $answer->is_correct, null);
            $this->answerRepository->save($answerObject);
        }
    }

    private function updateAnswerSelect(ExamTypeQuestionAnswerForm $form, $quest_id) {
        $deletedIDs = array_diff($form->oldIds, array_filter(ArrayHelper::map($form->answer, 'id', 'id')));
        if (!empty($deletedIDs)) {
            ExamAnswer::deleteAll(['id'=>$deletedIDs]);
        }
        foreach ($form->answer as $index => $answer) {
            if ($answer->id) {
                $answerModel = $this->answerRepository->get($answer->id);
                $answerModel->edit( $answer->name, $answer->is_correct, null);
            }else {
                $answerModel = ExamAnswer::create($quest_id, $answer->name, $answer->is_correct, null);
            }
            $this->answerRepository->save($answerModel);
        }
    }

    private function addAnswerSort(ExamTypeQuestionAnswerForm $form, $quest_id) {
        foreach ($form->answer as $answer) {
            $answerObject = ExamAnswer::create($quest_id, $answer->name, 1, null);
            $this->answerRepository->save($answerObject);
        }
    }

    private function updateAnswerSort(ExamTypeQuestionAnswerForm $form, $quest_id) {
        $deletedIDs = array_diff($form->oldIds, array_filter(ArrayHelper::map($form->answer, 'id', 'id')));
        if (!empty($deletedIDs)) {
            ExamAnswer::deleteAll(['id'=>$deletedIDs]);
        }
        foreach ($form->answer as $index => $answer) {
            if ($answer->id) {
                $answerModel = $this->answerRepository->get($answer->id);
                $answerModel->edit( $answer->name, 1, null);
            }else {
                $answerModel = ExamAnswer::create($quest_id, $answer->name, 1, null);
            }
            $this->answerRepository->save($answerModel);
        }
    }

    private function addAnswerMatching(ExamTypeQuestionAnswerForm $form, $quest_id) {
        foreach ($form->answer as $answer) {
            $isCorrect = $answer->name ? 1 : 0;
            $answerObject = ExamAnswer::create($quest_id, $answer->name, $isCorrect, $answer->answer_match);
            $this->answerRepository->save($answerObject);
        }
    }

    private function updateAnswerMatching(ExamTypeQuestionAnswerForm $form, $quest_id) {
        $deletedIDs = array_diff($form->oldIds, array_filter(ArrayHelper::map($form->answer, 'id', 'id')));
        if (!empty($deletedIDs)) {
            ExamAnswer::deleteAll(['id'=>$deletedIDs]);
        }
        foreach ($form->answer as $index => $answer) {
            $isCorrect = $answer->name ? 1 : 0;
            if ($answer->id) {
                $answerModel = $this->answerRepository->get($answer->id);
                $answerModel->edit($answer->name, $isCorrect, $answer->answer_match);
            }else {
                $answerModel = ExamAnswer::create($quest_id, $answer->name, $isCorrect, $answer->answer_match);
            }
            $this->answerRepository->save($answerModel);
        }
    }

    private function addAnswer(ExamTypeQuestionAnswerForm $form, $type_id, $quest_id) {
        if ($type_id == TestQuestionHelper::TYPE_SELECT || $type_id == TestQuestionHelper::TYPE_SELECT_ONE) {
            $this->addAnswerSelect($form, $quest_id);
        } else if ($type_id == TestQuestionHelper::TYPE_ANSWER_SHORT) {
            $this->addAnswerSort($form, $quest_id);
        } else if ($type_id == TestQuestionHelper::TYPE_MATCHING) {
            $this->addAnswerMatching($form, $quest_id);
        } else if ($type_id == TestQuestionHelper::TYPE_MATCHING_SAME) {
            $this->addAnswerMatching($form, $quest_id);
        }

    }

    private function updateAnswer(ExamTypeQuestionAnswerForm $form, $type_id, $quest_id) {
        if ($type_id === TestQuestionHelper::TYPE_SELECT || $type_id ===  TestQuestionHelper::TYPE_SELECT_ONE) {
            $this->updateAnswerSelect($form, $quest_id);
        } else if ($type_id === TestQuestionHelper::TYPE_ANSWER_SHORT) {
            $this->updateAnswerSort($form, $quest_id);
        } else if ($type_id === TestQuestionHelper::TYPE_MATCHING) {
            $this->updateAnswerMatching($form, $quest_id);
        } else if ($type_id === TestQuestionHelper::TYPE_MATCHING_SAME) {
            $this->updateAnswerMatching($form, $quest_id);
        }
    }


    public function createNested(ExamQuestionNestedCreateForm $form)
    {
        $this->transactionManager->wrap(function () use ( $form) {
            $model = $this->create($form->question);
            if($form->questProp) {
                foreach ($form->questProp as $index => $questProp) {
                    $questPropModel = ExamQuestionNested::create($model->id, $questProp->name, $questProp->is_start, $questProp->type);
                    $this->questionNestedRepository->save($questPropModel);
                    if($questProp->type) {
                        foreach ($form->answerCloze[$index] as $answerCloze) {
                            if ($answerCloze->name) {
                                $isCorrect = $questProp->type == TestQuestionHelper::CLOZE_TEXT ? 1 : $answerCloze->is_correct;
                                $answerClozeModel = ExamAnswerNested::create($questPropModel->id, $answerCloze->name, $isCorrect);
                                $this->answerNestedRepository->save($answerClozeModel);
                            }
                        }
                    }
                }
            }
        });
    }

    public function updateNested($id, ExamQuestionNestedUpdateForm $form)
    {
        $deletedQuestionPropIdsIDs = array_diff($form->oldQuestionPropIds, array_filter(ArrayHelper::map($form->questProp, 'id', 'id')));
        $deletedAnswerClozeIds = array_diff($form->oldAnswerClozeIds, $form->answerClozeIds);
        $this->transactionManager->wrap(function () use ($id, $form, $deletedQuestionPropIdsIDs, $deletedAnswerClozeIds) {
            $this->edit($id, $form->question);
            if (!empty($deletedQuestionPropIdsIDs)) {
                ExamQuestionNested::deleteAll(['id'=>$deletedQuestionPropIdsIDs]);
            }
            if (!empty($deletedAnswerClozeIds)) {
                ExamAnswerNested::deleteAll(['id'=>$deletedAnswerClozeIds]);
            }
            if($form->questProp) {
                foreach ($form->questProp as $index => $questProp) {
                    if ($questProp->id) {
                        $questPropModel  = $this->questionNestedRepository->get($questProp->id);
                        $questPropModel->edit($questProp->name, $questProp->is_start, $questProp->type);
                    }else {
                        $questPropModel = ExamQuestionNested::create($id, $questProp->name, $questProp->is_start, $questProp->type);
                    }
                    $this->questionNestedRepository->save($questPropModel);
                    if($questProp->type) {
                        $answerCloze = \Yii::$app->request->post('ExamAnswerNestedForm');
                        if ($answerCloze) {
                            foreach ($answerCloze[$index] as $answer) {
                                if ($answer['name']) {
                                    $isCorrect = $questProp->type == TestQuestionHelper::CLOZE_TEXT ? 1 : $answer['is_correct'];
                                    if ( $answer['id']) {
                                        $answerClozeModel = $this->answerNestedRepository->get($answer['id']);
                                        $answerClozeModel->edit($answer['name'], $isCorrect);
                                    }else {
                                        $answerClozeModel = ExamAnswerNested::create($questPropModel->id, $answer['name'], $isCorrect);
                                    }
                                    $this->answerNestedRepository->save($answerClozeModel);
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}