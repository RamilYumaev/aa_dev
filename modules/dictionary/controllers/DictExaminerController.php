<?php

namespace modules\dictionary\controllers;


use modules\dictionary\forms\DictExaminerForm;
use modules\dictionary\models\DictExaminer;
use modules\dictionary\searches\DictExaminerSearch;
use modules\dictionary\services\DictExaminerService;
use modules\usecase\ControllerClass;

class DictExaminerController extends ControllerClass
{
    public function __construct($id, $module,
                                DictExaminerService $service,
                                DictExaminerForm $formModel,
                                DictExaminer $model,DictExaminerSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;

    }

}