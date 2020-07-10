<?php


namespace modules\entrant\services;


use common\transactions\TransactionManager;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\StatementIndividualAchievementsMessageForm;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\forms\StatementRejectionCgMessageForm;
use modules\entrant\forms\StatementRejectionConsentMessageForm;
use modules\entrant\forms\StatementRejectionMessageForm;
use modules\entrant\helpers\FileHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\repositories\FileRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementCgRepository;
use modules\entrant\repositories\StatementConsentCgRepository;
use modules\entrant\repositories\StatementRejectionCgConsentRepository;
use modules\entrant\repositories\StatementRejectionCgRepository;
use modules\entrant\repositories\StatementRejectionRepository;
use modules\entrant\repositories\StatementRepository;
use modules\entrant\repositories\UserCgRepository;

class StatementService
{
    private $repository;
    private $manager;
    private $cgRepository;
    private $otherDocumentRepository;
    private $statementRejectionRepository;
    private $rejectionCgConsentRepository;
    private $rejectionCgRepository;
    private $fileRepository;
    private $consentCgRepository;
    /**
     * @var UserCgRepository
     */
    private $userCgRepository;

    public function __construct(StatementRepository $repository, UserCgRepository $userCgRepository,
                                StatementCgRepository $cgRepository,
                                OtherDocumentRepository $otherDocumentRepository,
                                StatementRejectionRepository $statementRejectionRepository,
                                StatementRejectionCgConsentRepository $rejectionCgConsentRepository,
                                StatementRejectionCgRepository $rejectionCgRepository,
                                StatementConsentCgRepository $consentCgRepository,
                                FileRepository $fileRepository,
                                TransactionManager $manager)
    {
        $this->repository = $repository;
        $this->manager = $manager;
        $this->cgRepository = $cgRepository;
        $this->userCgRepository = $userCgRepository;
        $this->otherDocumentRepository = $otherDocumentRepository;
        $this->statementRejectionRepository = $statementRejectionRepository;
        $this->rejectionCgConsentRepository  = $rejectionCgConsentRepository;
        $this->rejectionCgRepository = $rejectionCgRepository;
        $this->fileRepository = $fileRepository;
        $this->consentCgRepository = $consentCgRepository;
    }

    public function create($facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory)
    {
        $this->manager->wrap(function () use ($facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory) {
                $model = Statement::find();
                $data = DictCompetitiveGroupHelper::idAllUser($userId, $facultyId, $specialityId, $specialRight, DictCompetitiveGroupHelper::categoryForm()[$formCategory]);
                $max =  $model->lastMaxCounter($facultyId, $specialityId, $specialRight, $eduLevel, $userId, $formCategory);
                $modelOne = $model->statementUser($facultyId, $specialityId, $specialRight, $eduLevel, Statement::DRAFT, $userId, $formCategory);
                if(!$modelOne) {
                    if ($this->isStatementCg($data, $userId)) {
                        $statement = Statement::create($userId, $facultyId, $specialityId, $specialRight, $eduLevel, ++$max, $formCategory);
                        $this->repository->save($statement);
                        $this->statementCg($data, $userId, $statement->id);
                    }
                } else {
                    $this->statementCg($data, $userId, $modelOne->id);
                }
                if($specialRight == DictCompetitiveGroupHelper::TARGET_PLACE) {
                    $this->addOtherDoc($userId, OtherDocumentHelper::STATEMENT_TARGET);
                }
        });
    }

    public function addCountPages($id, $count){
        $statement = $this->repository->get($id);
        $statement->setCountPages($count);
        $this->repository->save($statement);
    }

    public function addCountPagesRejection($id, $count){
        $statement = $this->statementRejectionRepository->get($id);
        $statement->setCountPages($count);
        $this->statementRejectionRepository->save($statement);
    }

    public function addCountPagesCg($id, $count){
        $statement = $this->rejectionCgRepository->get($id);
        $statement->setCountPages($count);
        $this->cgRepository->save($statement);
    }

    public function addCountPagesConsent($id, $count){
        $statement = $this->rejectionCgConsentRepository->get($id);
        $statement->setCountPages($count);
        $this->rejectionCgConsentRepository->save($statement);
    }





    public function remove($id, $userId){
        $statementCg = $this->cgRepository->getUser($id, $userId);
        $this->manager->wrap(function () use($statementCg){
            $userCg =$this->userCgRepository->getUser($statementCg->cg_id, $statementCg->statement->user_id);
            $statement = $this->repository->get($statementCg->statement_id);
            if($statement->files) {
                throw new \DomainException('Вы не можете удалить заявление, так как загружен файл!');
            }
            if($statementCg->statementConsentFiles)  {
                throw new \DomainException('Вы не можете удалить образовательную программу, так как загружен файл заявления о согласии на зачисление!');
            }
            $this->userCgRepository->remove($userCg);
            if($statement->getStatementCg()->count() == 1) {
                if($statement->special_right == DictCompetitiveGroupHelper::TARGET_PLACE) {
                    $this->otherDocDelete($statement->user_id, OtherDocumentHelper::STATEMENT_TARGET);
                }
                $this->repository->remove($statement);
            } else {
                $this->cgRepository->remove($statementCg);
            }
        });
    }

    public function rejectionCg($id, $userId){
        $statementCg = $this->cgRepository->getUserStatementCg($id, $userId);
        $this->rejectionCgRepository->isStatementRejection($statementCg->id);
        $this->rejectionCgRepository->save(StatementRejectionCg::create($statementCg->id));

    }

    public function rejection($id) {
        $statement = $this->repository->get($id);
        $this->statementRejectionRepository->isStatementRejection($statement->id);
        $this->statementRejectionRepository->save(StatementRejection::create($statement->id));
    }

    public function rejectionRemoveCg($id) {
        $statement = $this->rejectionCgRepository->get($id);
        $this->rejectionCgRepository->remove($statement);
    }

    public function rejectionRemove($id) {
        $statement = $this->statementRejectionRepository->get($id);
        $this->statementRejectionRepository->remove($statement);
    }


    private function addOtherDoc($user_id, $type) {
        $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if(!$other && !\Yii::$app->user->identity->eighteenYearsOld()) {
            $this->otherDocumentRepository->save(OtherDocument::createNote(
                $type, DictIncomingDocumentTypeHelper::ID_AFTER_DOC, $user_id,null ));
            }

    }
    private function otherDocDelete($user_id, $type) {
        $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if($other) {
            $this->otherDocumentRepository->remove($other);
        }
    }

    private function statementCg($data, $userId, $statementId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                $cgUser = $this->userCgRepository->getUser($value, $userId);
                $statementCg = StatementCg::create($statementId, $value, null, $cgUser->cathedra_id);
                $this->cgRepository->save($statementCg);
            }
        }
    }

    private function isExits($cgId, $userId)
    {
        return Statement::find()->joinWith('statementCg')->where(['cg_id' => $cgId, 'user_id' => $userId ])->exists();
    }

    private function isStatementCg($data, $userId){
        foreach ($data as $value) {
            if (!$this->isExits($value, $userId)){
                 return true;
            }
        }
        return false;
    }

    public function addMessageRejection($id, StatementRejectionMessageForm $form)
    {   $model = $this->statementRejectionRepository->get($id);
        $this->manager->wrap(function () use ($model, $form) {
            $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                $this->fileRepository->save($file);
            }
            $model->setMessage($form->message);
            $this->repository->save($model);
        });
    }

    public function statusRejection($id, $status)
    {   $model = $this->statementRejectionRepository->get($id);
        $this->manager->wrap(function () use ($model,  $status) {
            $model->setStatus($status);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $this->fileRepository->save($file);
            }
            $model->setMessage(null);
            $this->repository->save($model);
        });
    }


    public function addMessage($id, StatementMessageForm $form)
    {   $model = $this->repository->get($id);
        $this->manager->wrap(function () use ($model, $form) {
            $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
            /* @var $st \modules\entrant\models\StatementCg */
            foreach($model->statementCg as $st) {
                /* @var $consent \modules\entrant\models\StatementConsentCg */
                foreach ($st->statementConsent as $consent)   {
                    $consent->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
                    /* @var $fileConsent \modules\entrant\models\File */
                    foreach($consent->files as $fileConsent) {
                        $fileConsent->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                        $this->fileRepository->save($fileConsent);
                    }
                    $this->consentCgRepository->save($consent);
                }
            }
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                $this->fileRepository->save($file);
            }
            $model->setMessage($form->message);
            $this->repository->save($model);
        });
    }

    public function status($id, $status)
    {   $model = $this->repository->get($id);
        $this->manager->wrap(function () use ($model, $status) {
            $model->setStatus($status);
            /* @var $st \modules\entrant\models\StatementCg */
            foreach($model->statementCg as $st) {
                /* @var $consent \modules\entrant\models\StatementConsentCg */
                foreach ($st->statementConsent as $consent)   {
                    $consent->setStatus(StatementHelper::STATUS_WALT);
                    /* @var $fileConsent \modules\entrant\models\File */
                    foreach($consent->files as $fileConsent) {
                        $fileConsent->setStatus(FileHelper::STATUS_WALT);
                        $this->fileRepository->save($fileConsent);
                    }
                    $this->consentCgRepository->save($consent);
                }
            }
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $this->fileRepository->save($file);
            }
            $model->setMessage(null);
            $this->repository->save($model);
        });
    }

    public function statusView($id)
    {   $model = $this->repository->get($id);
        $model->setStatus(StatementHelper::STATUS_VIEW);
        $this->repository->save($model);
    }

    public function statusRejectionView($id)
    {   $model = $this->statementRejectionRepository->get($id);
        $model->setStatus(StatementHelper::STATUS_VIEW);
        $this->repository->save($model);
    }

    public function addMessageConsent($id, StatementRejectionConsentMessageForm $form)
    {  $model = $this->rejectionCgConsentRepository->get($id);
        $this->manager->wrap(function () use ($model, $form) {
            $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                $this->fileRepository->save($file);
            }
            $model->setMessage($form->message);
            $this->repository->save($model);
        });
    }

    public function statusConsent($id, $status)
    {  $model = $this->rejectionCgConsentRepository->get($id);
        $this->manager->wrap(function () use ($model, $status) {
            $model->setStatus($status);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $this->fileRepository->save($file);
            }
            $model->setMessage(null);
            $this->repository->save($model);
        });
    }

    public function addMessageCg($id, StatementRejectionCgMessageForm $form)
    {  $model = $this->rejectionCgRepository->get($id);
        $this->manager->wrap(function () use ($model, $form) {
            $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_NO_ACCEPTED);
                $this->fileRepository->save($file);
            }
            $model->setMessage($form->message);
            $this->repository->save($model);
        });
    }

    public function statusCg($id, $status)
    {  $model = $this->rejectionCgRepository->get($id);
        $this->manager->wrap(function () use ($model, $status) {
            $model->setStatus($status);
            /* @var $file \modules\entrant\models\File */
            foreach($model->files as $file) {
                $file->setStatus(FileHelper::STATUS_WALT);
                $this->fileRepository->save($file);
            }
            $model->setMessage(null);
            $this->repository->save($model);
        });
    }

    public function statusRejectionConsentView($id)
    {
        $model = $this->rejectionCgConsentRepository->get($id);
       $model->setStatus(StatementHelper::STATUS_VIEW);
       $this->rejectionCgConsentRepository->save($model);
    }


}