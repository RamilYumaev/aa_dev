<?php

namespace modules\management\controllers\director;

use modules\management\forms\RegistryDocumentForm;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\searches\RegistryDocumentSearch;
use modules\management\searches\TaskSearch;
use modules\management\services\RegistryDocumentService;
use modules\management\services\TaskService;
use modules\management\forms\TaskForm;
use modules\management\models\Task;
use modules\usecase\ControllerClass;
use Yii;
use yii\base\Model;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class TaskController extends ControllerClass
{
    private $registryDocumentService;

    public function __construct($id, $module,
                                TaskService $service,
                                TaskForm $formModel,
                                Task $model,
                                TaskSearch $searchModel,
                                RegistryDocumentService $registryDocumentService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
        $this->registryDocumentService = $registryDocumentService;
    }

    public function actionWork($userId)
    {
        $schedule = Schedule::findOne(['user_id'=> $userId]);
        return $this->renderAjax('_work',[ 'schedule'=> $schedule]);
    }

    /**
     * @return mixed|string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        /** @var TaskForm $form */
        $form = new $this->formModel;
        $form->director_user_id = $this->getUser();
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
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreateDocument($id)
    {
        $model = $this->findModel($id);
        $form = new RegistryDocumentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->registryDocumentService->createForTask($form,$model->id);
                return $this->redirect(['view', 'id'=> $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create-document', [
            'model' => $form,
            'task' => $model
        ]);
    }


    public function getUser() {
        return Yii::$app->user->identity->getId();
    }


    /**
     * @return string|Response
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionRework($id)
    {
        $model = $this->findModel($id);
        /** @var TaskForm $form */
        $schedule = Schedule::findOne(['user_id'=> $model->responsible_user_id]);
        $form = new $this->formModel($model);
        $form->scenario = TaskForm::SCENARIO_NOTE_REWORK;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->rework($model->id, $form);
                return $this->redirect(Yii::$app->request->referrer);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->renderAjax('_rework', [
            'model' => $form,
            'schedule'=> $schedule
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
        $searchModel = new $this->searchModel($overdue, 'director_user_id');
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

    /**
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDocumentSearch($id)
    {
        $model = $this->findModel($id);
        $searchModel = new RegistryDocumentSearch($model);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('_search_document', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'task' => $model,
        ]);

    }

    /**

     * @return string
     * @throws NotFoundHttpException
     */

    public function actionSelectDocument($id, $document_id, $check)
    {
        $model = $this->findModel($id);
        try {
            $msg = $this->registryDocumentService->handleDocumentTask($document_id,$model->id, $check);
        } catch (\DomainException $e) {
            $msg = $e->getMessage();
        }
        Yii::$app->response->format = Response::FORMAT_RAW;
        return  $msg;

    }
}