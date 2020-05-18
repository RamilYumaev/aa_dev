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
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\repositories\DocumentEducationRepository;
use modules\entrant\repositories\OtherDocumentRepository;
use supplyhog\ClipboardJs\ClipboardJsAsset;

class DocumentEducationService
{

    private $repository;
    private $userSchoolRepository;
    private $otherDocumentRepository;
    private $transactionManager;

    public function __construct(DocumentEducationRepository $repository, UserSchoolRepository $userSchoolRepository, OtherDocumentRepository $otherDocumentRepository, TransactionManager $transactionManager)
    {
        $this->repository = $repository;
        $this->userSchoolRepository = $userSchoolRepository;
        $this->otherDocumentRepository = $otherDocumentRepository;
        $this->transactionManager = $transactionManager;
    }

    public function create(DocumentEducationForm $form)
    {   $userSchool = $this->schoolUser($form->school_id);
        $model = DocumentEducation::create($form, $userSchool->school_id);
        $this->repository->save($model);
        $this->addOtherDoc($model->school->country_id !== DictCountryHelper::RUSSIA, $model->user_id, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);
        return $model;
    }

    public function edit($id, DocumentEducationForm $form)
    {
        $this->transactionManager->wrap(function () use($id, $form) {
            $model = $this->repository->get($id);
            $userSchool = $this->schoolUser($form->school_id);
            $model->data($form, $userSchool->school_id);
            $this->addOtherDoc(!$model->school->country_id !== DictCountryHelper::RUSSIA, $model->user_id, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);
            $model->save($model);
        });
    }

    private function addOtherDoc($if, $user_id, $type) {
        $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if ($if)  {
            if(!$other) {
                $this->otherDocumentRepository->save(OtherDocument::createNote(
                    $type, DictIncomingDocumentTypeHelper::ID_AFTER_DOC, $user_id,null ));
            }
        } else {
            if($other) {
                $this->otherDocumentRepository->remove($other);
            }
        }
    }
    private function otherDocDelete($user_id, $type) {
       $other = $this->otherDocumentRepository->getUserNote($user_id, $type);
        if($other) {
            $this->otherDocumentRepository->remove($other);
        }
    }

    private function schoolUser($schoolId) : UserSchool
    {
        return  $this->userSchoolRepository->getSchoolUserId($schoolId, \Yii::$app->user->identity->getId());
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $userId = $model->user_id;
        $this->repository->remove($model);
        $this->otherDocDelete($userId, OtherDocumentHelper::TRANSLATION_DOCUMENT_EDU);

    }

}