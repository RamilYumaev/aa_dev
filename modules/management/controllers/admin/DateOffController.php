<?php

namespace modules\management\controllers\admin;


use modules\management\searches\DateOffSearch;
use modules\management\services\DateOffService;
use modules\management\forms\DateOffForm;
use modules\management\models\DateOff;
use modules\usecase\ControllerClass;
use Yii;
use yii\web\NotFoundHttpException;

class DateOffController extends ControllerClass
{
    public function __construct($id, $module,
                                DateOffService $service,
                                DateOffForm $formModel,
                                DateOff $model,
                                DateOffSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Throwable
     */
    public function actionAllowed($id, $is)
    {
        $model = $this->findModel($id);
        try{
            $this->service->allowed($model->id, $is);
        }catch (\Exception $e) {
            Yii::$app->session->setFlash('danger', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}