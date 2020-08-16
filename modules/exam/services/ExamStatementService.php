<?php
namespace modules\exam\services;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\services\UserAisService;
use modules\exam\forms\ExamDateReserveForm;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamSrcBBBForm;
use modules\exam\forms\ExamStatementMessageForm;
use modules\exam\forms\ExamStatementProctorForm;
use modules\exam\helpers\ExamCgUserHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\Exam;
use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamStatement;
use modules\exam\models\ExamViolation;
use modules\exam\repositories\ExamAttemptRepository;
use modules\exam\repositories\ExamRepository;
use modules\exam\repositories\ExamStatementRepository;

class ExamStatementService
{
    private $repository;
    private $examRepository;
    private $examAttemptRepository;
    private $aisService;

    public function __construct(ExamStatementRepository $repository, UserAisService $aisService, ExamRepository $examRepository,
                                ExamAttemptRepository $examAttemptRepository)
    {
        $this->repository = $repository;
        $this->examRepository = $examRepository;
        $this->examAttemptRepository = $examAttemptRepository;
        $this->aisService = $aisService;
    }

    public function register($examId, $userId, $type)
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
        if($type && !$exam->date_start_reserve) {
            throw new \DomainException("Зарегистриурйте позже, дата экзамена еще не определена");
        }
        if(($type && $exam->isDateReserveExamEnd()) || (!$type && $exam->isDateExamEnd())) {
            throw new \DomainException("Экзамен закончился");
        }
        $this->repository->save(ExamStatement::create($userId, $exam->id, $type ? $exam->date_start_reserve : $exam->date_start, $type));
    }

    public function addSrc($id, ExamSrcBBBForm $form, JobEntrant $jobEntrant)
    {
        $model = $this->repository->get($id);
        if($form->src_bbb){
            $model->data($jobEntrant->user_id, $form->src_bbb, $form->time);
            $this->repository->save($model);
            $this->aisService->examSend($jobEntrant->email_id, $model->entrant_user_id,
                $model->textEmailFirst, $model->urlExam, $model->time);
        }
    }

    public function status($id, $status)
    {
        $array = [ExamStatementHelper::SUCCESS_STATUS, ExamStatementHelper::END_STATUS];
        $model = $this->repository->get($id);
        if($model->getViolation()->count() && $status == ExamStatementHelper::END_STATUS) {
            throw new \DomainException("Вы не можете завершить, так как имеются нарушения");
        }

        $count = ExamStatement::find()->where(['status' => ExamStatementHelper::SUCCESS_STATUS,
            'entrant_user_id' => $model->entrant_user_id])->count();

        if($status == ExamStatementHelper::SUCCESS_STATUS && $count > 0) {
            throw new \DomainException("Вы не можете допустиь  абитуриента к сдаче больше 1 экзамена одновременно");
        }

        if($status == ExamStatementHelper::SUCCESS_STATUS) {
           $this->isStartExam($model);
        }

        if(!in_array($status, $array)) {
            throw new \DomainException("Можно только допустить или завершить");
        }

        $model->setStatus($status);
        $this->repository->save($model);
    }

    public function addMessage($id, ExamStatementMessageForm $form)
    {
        $model = $this->repository->get($id);
        $model->setStatus(ExamStatementHelper::ERROR_RESERVE_STATUS);
        $model->setMessage($form->message);
        $this->repository->save($model);
    }

    public function resetViolation($id)
    {
        $model = $this->repository->get($id);
        if(!$model->statusError()) {
            throw new \DomainException('Данная заявка не имеет статуса "Нарушение"');
        }
        $model->setStatus(ExamStatementHelper::END_STATUS);
        ExamViolation::deleteAll(['exam_statement_id' => $model->id]);
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
        $attempt = $this->examAttemptRepository->attemptExamUser($model->exam_id, $model->entrant_user_id);
        if($attempt) {
            $this->examAttemptRepository->remove($attempt);
        }
        $this->aisService->examSend($jobEntrant->email_id, $modelNew->entrant_user_id,
            $modelNew->textEmailReserve, $modelNew->urlExam, null);

    }

    public function resetAttempt($id)
    {
        $model = $this->repository->get($id);
        $model->setStatus(ExamStatementHelper::CANCEL_STATUS);
        $this->repository->save($model);
        $attempt = $this->examAttemptRepository->attemptExamUser($model->exam_id, $model->entrant_user_id);
        if($attempt) {
            $this->examAttemptRepository->remove($attempt);
        }
    }

    private function isStartExam(ExamStatement $examStatement) {
        if($examStatement->typeOch() && !(time() > strtotime($examStatement->exam->dateTimeStartExam))) {
            throw new \DomainException("Не может быть допущен раньше ".$examStatement->exam->dateTimeStartExam);
        }
        if($examStatement->typeZaOch() && !(time() > strtotime($examStatement->exam->dateTimeReserveStartExam))) {
            throw new \DomainException("Не может быть допущен раньше ".$examStatement->exam->dateTimeReserveStartExam);
        }
        if($examStatement->typeReserve() && !(time() > strtotime($examStatement->date." ".$examStatement->exam->time_start))) {
            throw new \DomainException("Не может быть допущен раньше ".$examStatement->date." ".$examStatement->exam->time_start);
        }
    }

    public function addAllStatement($eduLevel, $formCategory, $off) {
        $users = StatementCg::find()->statementUserLevelCg($eduLevel, $formCategory, $off);
        foreach ($users as $user) {
            $disciplines = ExamCgUserHelper::disciplineLevel($user, $eduLevel, $formCategory);
            if(!$disciplines) {
                continue;
            }
            foreach ($disciplines as $discipline) {
                $exam = $this->examRepository->getDisciplineId($discipline);
                if(!$exam){
                    continue;
                }
                if($this->repository->getExamUserExists($exam->id, $user)) {
                    continue;
                }
                if($formCategory == DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2 && !$exam->date_start_reserve) {
                    continue;
                }

                $examSt = ExamStatement::create(
                    $user,
                    $exam->id,
                    $formCategory == DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2 ?
                        $exam->date_start_reserve : $exam->date_start,
                    $formCategory == DictCompetitiveGroupHelper::FORM_EDU_CATEGORY_2 ? 1 :0 );

                $this->repository->save($examSt);
            }

        }

    }

    public function updateProctor($id, ExamStatementProctorForm $form)
    {
        $model = $this->repository->get($id);
        $model->setProctor($form->proctor_user_id);
        $model->setTime($form->time);
        $this->repository->save($model);
    }

}