<?php

namespace operator\controllers\dictionary;

use dictionary\forms\DictClassCreateForm;
use dictionary\forms\DictClassEditForm;
use dictionary\forms\DictChairmansCreateForm;
use dictionary\models\DictClass;
use dictionary\services\DictClassService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DictClassController extends Controller
{
    private $service;

    public function __construct($id, $module, DictClassService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionGetClassOnType($onlyHs)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['class' => $this->service->allClassesAjax($onlyHs)];

    }

}
