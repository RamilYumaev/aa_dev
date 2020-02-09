<?php

namespace dictionary\services;

use common\auth\forms\UserEmailForm;
//use dictionary\forms\DictSchoolsReportCreateForm;
//use dictionary\forms\DictSchoolsReportEditForm;
use dictionary\models\DictSchoolsReport;
use dictionary\repositories\DictSchoolsReportRepository;

class DictSchoolsReportService
{
    private $repository;

    public function __construct(DictSchoolsReportRepository $repository)
    {
        $this->repository = $repository;
    }

//    public function create(DictSchoolsReportCreateForm $form)
//    {
//        $model = DictSchoolsReport::create($form->name, $form->country_id, $form->region_id);
//        $this->repository->save($model);
//    }
//
//    public function edit($id, DictSchoolsReportEditForm $form)
//    {
//        $model = $this->repository->get($id);
//        $model->edit($form->name, $form->country_id, $form->region_id);
//        $this->repository->save($model);
//    }
//

    public function remove($id)
    {
        $model = $this->repository->get($id);
        $this->repository->remove($model);
    }
}