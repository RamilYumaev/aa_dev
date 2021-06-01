<?php


namespace modules\dictionary\controllers;

use modules\dictionary\forms\DictTestingEntrantForm;
use modules\dictionary\models\DictTestingEntrant;
use modules\dictionary\searches\DictTestingEntrantSearch;
use modules\dictionary\services\DictTestingEntrantService;
use modules\usecase\ControllerClass;
use yii\filters\AccessControl;

class DictTestingEntrantController extends ControllerClass
{

    public function __construct($id, $module,
                                DictTestingEntrantService $service,
                                DictTestingEntrant $model,
                                DictTestingEntrantForm $formModel,
                                DictTestingEntrantSearch $searchModel,
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
                        'roles' => ['dev','volunteering']
                    ]
                ],
            ],
        ];
    }
}