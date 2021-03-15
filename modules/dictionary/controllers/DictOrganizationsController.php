<?php

namespace modules\dictionary\controllers;


use modules\dictionary\searches\DictOrganizationsSearch;
use modules\dictionary\services\DictOrganizationService;
use modules\dictionary\forms\DictOrganizationForm;
use modules\dictionary\models\DictOrganizations;
use modules\usecase\ControllerClass;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class DictOrganizationsController extends ControllerClass
{
    public function __construct($id, $module,
                                DictOrganizationService $service,
                                DictOrganizationForm $formModel,
                                DictOrganizations $model,
                                DictOrganizationsSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['dev']
                    ]
                ],
            ],
        ];
    }

}