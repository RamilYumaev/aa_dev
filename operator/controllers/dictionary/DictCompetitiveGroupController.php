<?php


namespace operator\controllers\dictionary;

use dictionary\services\DictCompetitiveGroupService;
use Yii;
use yii\web\Controller;
use yii\web\Response;

class DictCompetitiveGroupController extends Controller
{
    private $service;

    public function __construct($id, $module, DictCompetitiveGroupService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionGetCg($levelId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->service->getAllCg($levelId)];
    }

}