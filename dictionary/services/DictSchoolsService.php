<?php

namespace dictionary\services;

use common\auth\forms\UserEmailForm;
use common\transactions\TransactionManager;
use dictionary\forms\DictSchoolsCreateForm;
use dictionary\forms\DictSchoolsEditForm;
use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsReport;
use dictionary\repositories\DictSchoolsReportRepository;
use dictionary\repositories\DictSchoolsRepository;


class DictSchoolsService
{
    private $repository;
    private $transactionManager;
    private $reportRepository;

    public function __construct(DictSchoolsRepository $repository, TransactionManager $transactionManager, DictSchoolsReportRepository $reportRepository)
    {
        $this->repository = $repository;
        $this->transactionManager = $transactionManager;
        $this->reportRepository = $reportRepository;
    }

    public function create(DictSchoolsCreateForm $form)
    {
        $this->transactionManager->wrap(function () use ($form){
            $model = DictSchools::create($form->name, $form->country_id, $form->region_id);
            $this->repository->save($model);
            $this->addSchoolReport($model->id);
        });
    }

    public function addDictSchoolReportId($id, $school_id)
    {
        $reportModel = $this->reportRepository->get($school_id);
        $model = $this->repository->get($id);
        $model->setDictSchoolReportId($reportModel->id);
        $this->repository->save($model);
    }


    public function edit($id, DictSchoolsEditForm $form)
    {
        $model = $this->repository->get($id);
        $model->edit($form->name, $form->country_id, $form->region_id);
        $this->repository->save($model);
    }

    public function addEmail($id, UserEmailForm $form)
    {
        $model = $this->repository->get($id);
        $model->setEmail($form->email);
        $this->repository->save($model);
    }

    public function addSchoolReport($id) {
        $modelOne = $this->repository->get($id);
        $this->reportRepository->isSchoolId($modelOne->id);
        $reportModel = DictSchoolsReport::create($modelOne->id);
        $this->reportRepository->save($reportModel);
        $modelOne->setDictSchoolReportId($reportModel->id);
        $this->repository->save($modelOne);
    }

    public function resetReport($id) {
        $modelOne = $this->repository->get($id);
        $modelOne->setDictSchoolReportId(null);
        $this->repository->save($modelOne);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}