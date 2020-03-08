<?php
namespace modules\entrant\services;


use common\auth\models\UserSchool;
use common\auth\repositories\UserSchoolRepository;
use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\models\DocumentEducation;
use modules\entrant\repositories\DocumentEducationRepository;
use supplyhog\ClipboardJs\ClipboardJsAsset;

class DocumentEducationService
{

    private $repository;
    private $userSchoolRepository;

    public function __construct(DocumentEducationRepository $repository, UserSchoolRepository $userSchoolRepository)
    {
        $this->repository = $repository;
        $this->userSchoolRepository = $userSchoolRepository;
    }

    public function create(DocumentEducationForm $form)
    {
        $userSchool = $this->schoolUser($form->school_id);
        $model  = DocumentEducation::create($form, $userSchool->school_id);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DocumentEducationForm $form)
    {
        $model = $this->repository->get($id);
        $userSchool = $this->schoolUser($form->school_id);
        $model->data($form, $userSchool->school_id);
        $model->save($model);
    }

    private function schoolUser($schoolId) : UserSchool
    {
        return  $this->userSchoolRepository->getSchoolUserId($schoolId, \Yii::$app->user->identity->getId());
    }

}