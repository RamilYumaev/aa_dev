<?php

namespace modules\management\controllers\user;


use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\searches\TaskSearch;
use modules\management\searches\TaskUserSearch;
use modules\management\services\TaskService;
use modules\management\forms\TaskForm;
use modules\management\models\Task;
use modules\usecase\ControllerClass;
use Symfony\Component\Console\Helper\DebugFormatterHelper;
use Yii;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskController extends ControllerClass
{
    public function __construct($id, $module,
                                TaskService $service,
                                TaskForm $formModel,
                                Task $model,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
    }

    public function beforeAction($action)
    {
        if (!Yii::$app->user->getIsGuest() && $user = Yii::$app->user->identity->getId()) {
            /* @var $job  \modules\dictionary\models\JobEntrant */
            $isSchedule = Schedule::find()->user($user)->exists();
            if(!$isSchedule) {
                Yii::$app->session->setFlash('warning', "Заполните личный график работы");
                $this->redirect(['schedule/index']);
                Yii::$app->end();
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function actionIndex($overdue = null)
    {
        /**
         * @var $searchModel Model
         */
        $searchModel = new TaskUserSearch($overdue);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * @return mixed|string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $schedule =  $this->findScheduleModel();
        /** @var TaskForm $form */
        $form = new $this->formModel;
        $form->responsible_user_id = $this->getUser();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form);
                return $this->redirect(['view', 'id'=> $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'schedule'=> $schedule,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /**
         * @var $form Model
         */
        $schedule =  $this->findScheduleModel();
        $model = $this->findModel($id);
        $form = new $this->formModel($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['view', 'id'=> $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'schedule'=> $schedule,
        ]);
    }

    public function getUser() {
        return Yii::$app->user->identity->getId();
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


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): BaseActiveRecord
    {
        if (($model = Task::findOne(['id'=>$id, 'responsible_user_id'=> $this->getUser()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @return Schedule
     * @throws NotFoundHttpException
     */

    protected function findScheduleModel(): Schedule
    {
        if (($model = Schedule::findOne(['user_id'=> $this->getUser()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    public function actionTime($date)
    {
        $schedule = Schedule::findOne(['user_id'=> $this->getUser()]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> $schedule->getAllTimeWork($date)];
    }


}