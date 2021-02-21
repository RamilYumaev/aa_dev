<?php

namespace modules\management\controllers\user;


use modules\management\models\Schedule;
use modules\management\services\DateOffService;
use modules\management\forms\DateOffForm;
use modules\management\models\DateOff;
use modules\usecase\ControllerClass;
use Yii;
use yii\base\Model;
use yii\db\BaseActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DateOffController extends ControllerClass
{
    public function __construct($id, $module,
                                DateOffService $service,
                                DateOffForm $formModel,
                                DateOff $model,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
    }

    /**
     * @return mixed|string|Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $schedule =  $this->findScheduleModel();
        /** @var DateOffForm $form */
        $form = new $this->formModel;
        $form->schedule_id = $schedule->id;
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form);
                Yii::$app->session->setFlash('success','Вашу заявку на отгул в ближайшее время рассмотрят');
                return $this->redirect(['schedule/index']);
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
        $model = $this->findModel($id);
        /**
             * @var $form Model
         */
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
            'dateOff'=> $model,
        ]);
    }

    public function getUser() {
        return Yii::$app->user->identity->getId();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): BaseActiveRecord
    {
        $schedule  = $this->findScheduleModel();
        if (($model = DateOff::findOne(['id'=>$id, 'schedule_id'=>  $schedule->id ])) !== null) {
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