<?php


namespace modules\exam\services;;

use modules\exam\forms\ExamViolationForm;
use modules\exam\helpers\ExamQuestionHelper;
use modules\exam\models\ExamAnswer;
use modules\exam\models\ExamAnswerNested;
use modules\exam\models\ExamStatement;
use modules\exam\models\ExamViolation;
use modules\exam\repositories\ExamAttemptRepository;
use modules\exam\repositories\ExamQuestionInTestRepository;
use modules\exam\repositories\ExamQuestionRepository;
use modules\exam\repositories\ExamResultRepository;
use modules\exam\repositories\ExamStatementRepository;
use modules\exam\repositories\ExamTestRepository;
use modules\exam\repositories\ExamViolationRepository;
use testing\helpers\TestQuestionHelper;
use yii\helpers\Json;
use yii\web\UploadedFile;

class ExamViolationService
{
    private  $repository,
        $examStatementRepository;

    function __construct(ExamViolationRepository $repository,
                         ExamStatementRepository $examStatementRepository)
    {
        $this->repository = $repository;
        $this->examStatementRepository = $examStatementRepository;
    }

    public function create(ExamViolationForm $form) {
        $this->examStatementRepository->get($form->exam_statement_id);
        $this->repository->save(ExamViolation::create($form));
    }

    public function edit($id, ExamViolationForm $form) {
        $this->examStatementRepository->get($form->exam_statement_id);
        $model = $this->repository->get($id);
        $model->data($form);
        $this->repository->save($model);
    }

    public function remove($id) {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

}