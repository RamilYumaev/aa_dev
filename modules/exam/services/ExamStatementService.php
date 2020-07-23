<?php
namespace modules\exam\services;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\services\UserAisService;
use modules\exam\forms\ExamDateReserveForm;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamSrcBBBForm;
use modules\exam\forms\ExamStatementMessageForm;
use modules\exam\helpers\ExamCgUserHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\Exam;
use modules\exam\models\ExamStatement;
use modules\exam\repositories\ExamRepository;
use modules\exam\repositories\ExamStatementRepository;

class ExamStatementService
{
    private $repository;
    private $examRepository;
    private  $aisService;

    public function __construct(ExamStatementRepository $repository, UserAisService $aisService, ExamRepository $examRepository)
    {
        $this->repository = $repository;
        $this->examRepository = $examRepository;
        $this->aisService = $aisService;
    }

    public function register($examId, $userId)
    {
        $exam = $this->examRepository->get($examId);
        $disciplineUser = ExamCgUserHelper::disciplineExam($userId);
        if(!$disciplineUser || !is_array($disciplineUser)
            || !in_array($exam->discipline_id, $disciplineUser)) {
            throw new \DomainException("У вас нет доступа к экзамену");
        }
        if($this->repository->getExamUserExists($exam->id, $userId)) {
            throw new \DomainException("Такая заявка на экзамен существует");
        }
        $this->repository->save(ExamStatement::create($userId, $exam->id, $exam->date_start,0));
    }

    public function edit($id, ExamForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }

    public function addSrc($id, ExamSrcBBBForm $form, JobEntrant $jobEntrant)
    {
        $model = $this->repository->get($id);
        if($form->src_bbb){
            $model->data($jobEntrant->user_id, $form->src_bbb);
            $this->repository->save($model);
            $this->aisService->examSend($jobEntrant->email_id, $model->entrant_user_id,
                $model->textEmailFirst, $model->urlExam);
        }
    }

    public function status($id)
    {
        $model = $this->repository->get($id);
        $model->setStatus(ExamStatementHelper::SUCCESS_STATUS);
        $this->repository->save($model);
    }

    public function addMessage($id, ExamStatementMessageForm $form)
    {
        $model = $this->repository->get($id);
        $model->setStatus(ExamStatementHelper::ERROR_RESERVE_STATUS);
        $model->setMessage($form->message);
        $this->repository->save($model);
    }

    public function addReserveDate($id, ExamDateReserveForm $form, JobEntrant $jobEntrant)
    {
        $model = $this->repository->get($id);
        $model->setStatus(ExamStatementHelper::RESERVE_STATUS);
        $this->repository->save($model);
        $modelNew = ExamStatement::create($model->entrant_user_id, $model->exam_id,
        $form->date, ExamStatementHelper::RESERVE_TYPE);
        $this->repository->save($modelNew);

        $this->aisService->examSend($jobEntrant->email_id, $modelNew->entrant_user_id,
            $modelNew->textEmailReserve, $modelNew->urlExam);


    }

}