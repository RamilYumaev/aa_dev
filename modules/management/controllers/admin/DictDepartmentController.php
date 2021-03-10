<?php

namespace modules\management\controllers\admin;


use modules\management\searches\DictDepartmentSearch;
use modules\management\services\DictDepartmentService;
use modules\management\forms\DictDepartmentForm;
use modules\management\models\DictDepartment;
use modules\usecase\ControllerClass;

class DictDepartmentController extends ControllerClass
{
    public function __construct($id, $module,
                                DictDepartmentService $service,
                                DictDepartmentForm $formModel,
                                DictDepartment $model,
                                DictDepartmentSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id){
        $model = $this->findModel($id);

        return $this->render('view', ['model'=>$model]);
    }
}