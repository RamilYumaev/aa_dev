<?php

namespace modules\management\controllers\admin;


use modules\management\searches\DateFeastSearch;
use modules\management\services\DateFeastService;
use modules\management\forms\DateFeastForm;
use modules\management\models\DateFeast;
use modules\usecase\ControllerClass;

class DateFeastController extends ControllerClass
{
    public function __construct($id, $module,
                                DateFeastService $service,
                                DateFeastForm $formModel,
                                DateFeast $model,
                                DateFeastSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

}