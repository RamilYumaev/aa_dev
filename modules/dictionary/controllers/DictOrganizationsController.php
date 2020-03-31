<?php
namespace modules\dictionary\controllers;


use modules\dictionary\services\DictOrganizationService;
use modules\dictionary\forms\DictOrganizationForm;
use modules\dictionary\models\DictOrganizations;
use modules\usecase\ControllerClass;

class DictOrganizationsController extends ControllerClass
{
    public function __construct($id, $module,
                                DictOrganizationService $service,
                                DictOrganizationForm $formModel,
                                DictOrganizations $model,
                                $config = [])
    {
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;

        parent::__construct($id, $module, $config);
    }

}