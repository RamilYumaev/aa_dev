<?php
namespace modules\entrant\services;


use modules\entrant\forms\PassportDataForm;
use modules\entrant\models\PassportData;
use modules\entrant\repositories\PassportDataRepository;

class PassportDataService
{
    private $repository;

    public function __construct(PassportDataRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(PassportDataForm $form)
    {
        $model  = PassportData::create($form);
        $this->repository->save($model);
        return $model;
    }

    public function edit($id, PassportDataForm $form)
    {
        $model = $this->repository->get($id);
        $model->data($form);
        $model->save($model);
    }

}