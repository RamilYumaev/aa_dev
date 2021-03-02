<?php

namespace modules\management\controllers\admin;


use Codeception\Lib\Di;
use common\helpers\FileHelper;
use modules\management\models\DictTask;
use modules\management\models\PostManagement;
use modules\management\searches\PostRateDepartmentSearch;
use modules\management\services\PostRateDepartmentService;
use modules\management\forms\PostRateDepartmentForm;
use modules\management\models\PostRateDepartment;
use modules\usecase\ControllerClass;
use Yii;
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
        $column = $model->getManagementTask()->select(['dict_task_id'])->column();
        FileHelper::getFile(DictTask::find()->andWhere(['id'=>$column ])->asArray()->all(), $filePath, $fileName);
    }
}