<?php

namespace dictionary\services;

use common\auth\forms\UserEmailForm;
//use dictionary\forms\DictSchoolsReportCreateForm;
//use dictionary\forms\DictSchoolsReportEditForm;
use dictionary\models\DictSchools;
use dictionary\models\DictSchoolsReport;
use dictionary\repositories\DictSchoolsReportRepository;
use dictionary\repositories\DictSchoolsRepository;

class DictSchoolsReportService
{
    private $repository;
    private $schoolsRepository;

    public function __construct(DictSchoolsReportRepository $repository, DictSchoolsRepository $schoolsRepository)
    {
        $this->repository = $repository;
        $this->schoolsRepository = $schoolsRepository;
    }

    public function addIndex($id,$school_id)
    {
        $model = $this->repository->get($id);
        $school = $this->schoolsRepository->get($school_id);
        $model->edit($school->id);
        $this->repository->save($model);
    }

    public function remove($id)
    {
        $model = $this->repository->get($id);
        DictSchools::updateAll(['dict_school_report_id'=>null],['dict_school_report_id'=>$model->id]);
        $this->repository->remove($model);
    }
}