<?php

namespace modules\management\controllers\admin;


use modules\management\searches\PostRateDepartmentSearch;
use modules\management\services\PostRateDepartmentService;
use modules\management\forms\PostRateDepartmentForm;
use modules\management\models\PostRateDepartment;
use modules\usecase\ControllerClass;

class PostRateDepartmentController extends ControllerClass
{
    public function __construct($id, $module,
                                PostRateDepartmentService $service,
                                PostRateDepartmentForm $formModel,
                                PostRateDepartment $model,
                                PostRateDepartmentSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}