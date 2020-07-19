<?php

namespace modules\entrant\services;


use common\auth\models\UserSchool;
use common\auth\repositories\UserSchoolRepository;
use common\transactions\TransactionManager;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\AnketaForm;
use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\DocumentEducationRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use modules\entrant\repositories\StatementRepository;
use supplyhog\ClipboardJs\ClipboardJsAsset;

class DocumentEducationService
{

    private $repository;
    private $userSchoolRepository;
    private $otherDocumentRepository;
    private $transactionManager;
    private $statementRepository;

    public function __construct(DocumentEducationRepository $repository, UserSchoolRepository $userSchoolRepository,
                                OtherDocumentRepository $otherDocumentRepository, TransactionManager $transactionManager,
                                StatementRepository $statementRepository)
    {
        $this->repository = $repository;
        $this->userSchoolRepository = $userSchoolRepository;
        $this->otherDocumentRepository = $otherDocumentRepository;
        $this->transactionManager = $transactionManager;
        $this->statementRepository = $statementRepository;
    }

    public function create(DocumentEducationForm $form, Anketa $anketa)
    {
        $userSchool = $this->schoolUser($form->school_id);
        $this->conflictSchool($userSchool, $anketa);
        $model = DocumentEducation::create($form, $userSchool->school_id);
        $this->repository->save($model);
        $this->addOtherDoc($model->school->country_id !== DictCountryHelper::RUSSIA, $model->user_id, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);
        $this->addOtherDoc($form->without_appendix, $model->user_id, OtherDocumentHelper::WITHOUT_APPENDIX);
        return $model;
    }

    public function edit($id, DocumentEducationForm $form, Anketa $anketa)
    {
        $this->transactionManager->wrap(function () use ($id, $form, $anketa) {
            $model = $this->repository->get($id);
            $userSchool = $this->schoolUser($form->school_id);
            $this->conflictSchool($userSchool, $anketa);
            $model->data($form, $userSchool->school_id);
            $this->addOtherDoc($model->school->country_id !== DictCountryHelper::RUSSIA, $model->user_id, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);
            $this->addOtherDoc($form->without_appendix, $model->user_id, OtherDocumentHelper::WITHOUT_APPENDIX);
            if (!$this->statementRepository->getStatementStatusNoDraft($model->user_id)) {
                $model->detachBehavior("moderation");
            }
            $model->save($model);
        });
    }

    private function addOtherDoc($if, $user_id, $type)
    {
        $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if ($if) {
            if (!$other) {
                $this->otherDocumentRepository->save(OtherDocument::createNote(
                    $type, DictIncomingDocumentTypeHelper::ID_AFTER_DOC, $user_id, null));
            }
        } else {
            if ($other) {
                $this->otherDocumentRepository->remove($other);
            }
        }
    }

    private function otherDocDelete($user_id, $type)
    {
        $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if ($other) {
            $this->otherDocumentRepository->remove($other);
        }
    }

    private function schoolUser($schoolId): UserSchool
    {
        return $this->userSchoolRepository->getSchoolUserId($schoolId, \Yii::$app->user->identity->getId());
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $userId = $model->user_id;
        $this->repository->remove($model);
        $this->otherDocDelete($userId, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);
        $this->otherDocDelete($userId, OtherDocumentHelper::WITHOUT_APPENDIX);

    }

    public function conflictSchool(UserSchool $userSchool, Anketa $anketa)
    {
        if ($userSchool->school->isRussia() && $anketa->is_foreigner_edu_organization) {
            throw new \DomainException("Выявлено противоречие! В \"Определение условий подачи документов\" Вы указали, что 
            учебная организация находится на территории иностранного государства, а в разделе \"Учебные организации\" 
            указали, что учебная организания находится на территории РФ!");
        }
    }

}