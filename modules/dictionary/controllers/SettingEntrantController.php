<?php

namespace modules\dictionary\controllers;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\SettingEntrant;
use modules\dictionary\searches\JobEntrantSearch;
use modules\dictionary\searches\SettingEntrantSearch;
use modules\dictionary\services\JobEntrantService;
use modules\dictionary\services\SettingEntrantService;
use modules\usecase\ControllerClass;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class SettingEntrantController extends ControllerClass
{

    public function __construct($id, $module,
                                SettingEntrantService $service,
                                SettingEntrant $model,
                                SettingEntrantForm $formModel,
                                SettingEntrantSearch $searchModel,
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