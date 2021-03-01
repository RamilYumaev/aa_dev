<?php

namespace modules\management\controllers\admin;


use common\helpers\FileHelper;
use modules\management\searches\PostRateDepartmentSearch;
use modules\management\services\PostRateDepartmentService;
use modules\management\forms\PostRateDepartmentForm;
use modules\management\models\PostRateDepartment;
use modules\usecase\ControllerClass;
use olympic\models\auth\Profiles;
use yii\web\NotFoundHttpException;

class PostRateDepartmentController extends ControllerClass
{
    public function __construct($id, $module,
                                PostRateDepartmentService $service,
                                PostRateDepartmentForm $formModel,
                                PostRateDepartment $model,
                                PostRateDepartmentSearch $searchModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->model = $model;
        $this->formModel = $formModel;
        $this->service = $service;
        $this->searchModel = $searchModel;
    }

    /**
     * @param $id
     * @throws \yii\web\NotFoundHttpException
     */

    public function actionFile($id)
    {
        /** @var PostRateDepartment $model */
        $model = $this->findModel($id);
        $filePath = $model->getUploadedFilePath('template_file');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        $fileName = "Должностная инструкция ".$model->postManagement->name." ". ($model->dictDepartment ? $model->dictDepartment->name_short : ""). ".docx";

        FileHelper::getFile(['dd','dd'], $filePath, $fileName);
    }

}