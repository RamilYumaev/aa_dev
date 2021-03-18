<?php

namespace modules\management\controllers\user;


use modules\management\forms\RegistryDocumentForm;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\searches\RegistryDocumentSearch;
use modules\management\searches\TaskSearch;
use modules\management\searches\TaskUserSearch;
use modules\management\services\RegistryDocumentService;
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
    private $registryDocumentService;

    public function __construct($id, $module,
                                TaskService $service,
                                TaskForm $formModel,
                                Task $model,
                                RegistryDocumentService $registryDocumentService,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->registryDocumentService = $registryDocumentService;
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
        $searchModel = new TaskSearch($overdue);
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

     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view',[ 'task'=> $model]);
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


    public function actionTime($date)
    {
        $schedule = Schedule::findOne(['user_id'=> $this->getUser()]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> $schedule->getAllTimeWork($date)];
    }


}