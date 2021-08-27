<?php

namespace modules\entrant\controllers\backend;

use dictionary\services\DictCompetitiveGroupService;
use modules\entrant\forms\EventForm;
use modules\entrant\models\Event;
use modules\entrant\searches\EventSearch;
use modules\entrant\services\EventService;
use modules\usecase\ControllerClass;
use Yii;
use yii\filters\AccessControl;
use yii\web\Response;

class EventController extends ControllerClass
{
    private $dictCompetitiveGroupService;
    public function __construct($id, $module,
                                EventService $service,
                                Event $model,
                                EventForm $formModel,
                                DictCompetitiveGroupService $dictCompetitiveGroupService,
                                EventSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->model = $model;
        $this->formModel = $formModel;
        $this->searchModel = $searchModel;
        $this->dictCompetitiveGroupService = $dictCompetitiveGroupService;
    }

    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['entrant']
                    ]
                ],
            ],
        ];
    }

    public function actionFullCg($educationLevelId = null, $educationFormId = null,
                                 $facultyId = null, $specialityId = null,$foreignerStatus = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->dictCompetitiveGroupService->getAllFullCg('2020-2021', $educationLevelId, $educationFormId,
            $facultyId, $specialityId, $foreignerStatus, [1,2])];
    }
}