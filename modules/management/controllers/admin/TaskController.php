<?php

namespace modules\management\controllers\admin;


use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\searches\TaskSearch;
use modules\management\services\TaskService;
use modules\management\forms\TaskForm;
use modules\management\models\Task;
use modules\usecase\ControllerClass;
use Yii;
use yii\web\Response;

class TaskController extends ControllerClass
{
    public function __construct($id, $module,
                                TaskService $service,
                                TaskForm $formModel,
                                Task $model,
                                TaskSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    public function actionWork($userId)
    {
        $schedule = Schedule::findOne(['user_id'=> $userId]);
        return $this->renderAjax('_work',[ 'schedule'=> $schedule]);
    }

    /**

     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view',[ 'task'=> $model]);
    }


    public function actionTask($task)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> ManagementUser::find()->allColumnTask($task)];
    }

    public function actionTime($userId, $date)
    {
        $schedule = Schedule::findOne(['user_id'=> $userId]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> $schedule->getAllTimeWork($date)];
    }


}