<?php

namespace modules\dictionary\controllers;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\Volunteering;
use modules\dictionary\searches\JobEntrantSearch;
use modules\dictionary\searches\VolunteeringSearch;
use modules\dictionary\services\JobEntrantService;
use modules\dictionary\services\VolunteeringService;
use modules\usecase\ControllerClass;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class VolunteeringController extends ControllerClass
{

    public function __construct($id, $module,
                                VolunteeringService $service,
                                Volunteering $model,
                                VolunteeringForm $formModel,
                                VolunteeringSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
    }

    public function actionStatus($id, $status) {
        try {
            $this->service->status($id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);

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
                        'roles' => ['dev', 'volunteering']
                    ]
                ],
            ],
        ];
    }
}