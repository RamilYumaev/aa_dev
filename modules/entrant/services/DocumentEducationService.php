<?php
namespace modules\entrant\services;


use dictionary\repositories\DictSchoolsRepository;
use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\models\DocumentEducation;
use modules\entrant\repositories\DocumentEducationRepository;
use olympic\traits\NewOrRenameSchoolTrait;

class DocumentEducationService
{
    use NewOrRenameSchoolTrait;

    private $repository;
    private $dictSchoolsRepository;

    public function __construct(DocumentEducationRepository $repository, DictSchoolsRepository $dictSchoolsRepository)
    {
        $this->repository = $repository;
        $this->dictSchoolsRepository = $dictSchoolsRepository;
    }

    public function create(DocumentEducationForm $form)
    {
        $model  = DocumentEducation::create($form, $this->newOrRenameSchoolId($form->schoolUser, $this->dictSchoolsRepository));
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, DocumentEducationForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form, $this->newOrRenameSchoolId($form->schoolUser, $this->dictSchoolsRepository));
        $model->save($model);
    }

}