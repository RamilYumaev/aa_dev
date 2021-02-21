<?php

namespace modules\management\controllers\admin;


use modules\management\searches\DateWorkSearch;
use modules\management\services\DateWorkService;
use modules\management\forms\DateWorkForm;
use modules\management\models\DateWork;
use modules\usecase\ControllerClass;

class DateWorkController extends ControllerClass
{
    public function __construct($id, $module,
                                DateWorkService $service,
                                DateWorkForm $formModel,
                                DateWork $model,
                                DateWorkSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}