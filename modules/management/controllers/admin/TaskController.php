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
use yii\base\Model;
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

    public function beforeAction($action)
    {
        if (!Yii::$app->user->getIsGuest() && $user = Yii::$app->user->identity->getId()) {
            $isSchedule = Schedule::find()->user($user)->exists();
            if(!$isSchedule) {
                Yii::$app->session->setFlash('warning', "Заполните личный график работы");
                $this->redirect(['schedule/index']);
                Yii::$app->end();
            }
        }
        return true;
    }

    public function actionWork($userId)
    {
        $schedule = Schedule::findOne(['user_id'=> $userId]);
        return $this->renderAjax('_work',[ 'schedule'=> $schedule]);
    }

    /**
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionRework($id)
    {
        $model = $this->findModel($id);
        /** @var TaskForm $form */
        $form = new $this->formModel($model);
        $form->scenario = TaskForm::SCENARIO_NOTE_REWORK;
        if ($form->load(Yii::$app->request->post()) && $form->validate(false)) {
            try {
                $this->service->rework($model->id, $form->note);
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('_rework', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionIndex($overdue = null)
    {
        /**
         * @var $searchModel Model
         */
        $searchModel = new $this->searchModel($overdue, true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**

     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view',[ 'task'=> $model]);
    }

    /**

     * @throws \yii\web\NotFoundHttpException
     */
    public function actionStatus($id, $status)
    {
        $model = $this->findModel($id);
        try {
            $this->service->status($model->id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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