<?php

namespace modules\management\controllers\admin;


use modules\management\searches\DictTaskSearch;
use modules\management\services\DictTaskService;
use modules\management\forms\DictTaskForm;
use modules\management\models\DictTask;
use modules\usecase\ControllerClass;

class DictTaskController extends ControllerClass
{
    public function __construct($id, $module,
                                DictTaskService $service,
                                DictTaskForm $formModel,
                                DictTask $model,
                                DictTaskSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}