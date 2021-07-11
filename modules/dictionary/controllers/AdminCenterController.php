<?php


namespace modules\dictionary\controllers;

use modules\dictionary\forms\AdminCenterForm;
use modules\dictionary\models\AdminCenter;
use modules\dictionary\searches\AdminCenterSearch;
use modules\dictionary\services\AdminCenterService;
use modules\usecase\ControllerClass;
use yii\filters\AccessControl;


class AdminCenterController extends ControllerClass
{

    public function __construct($id, $module,
                                AdminCenterService $service,
                                AdminCenter $model,
                                AdminCenterForm $formModel,
                                AdminCenterSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
    }

    public function behaviors(): array
    {
        return [
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