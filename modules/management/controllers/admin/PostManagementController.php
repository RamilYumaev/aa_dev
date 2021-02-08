<?php

namespace modules\management\controllers\admin;


use modules\management\searches\PostManagementSearch;
use modules\management\services\PostManagementService;
use modules\management\forms\PostManagementForm;
use modules\management\models\PostManagement;
use modules\usecase\ControllerClass;

class PostManagementController extends ControllerClass
{
    public function __construct($id, $module,
                                PostManagementService $service,
                                PostManagementForm $formModel,
                                PostManagement $model,
                                PostManagementSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}