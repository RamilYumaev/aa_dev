<?php


namespace frontend\controllers;

use dictionary\readRepositories\DictSchoolsReadRepository;
use yii\web\Controller;
use yii\web\Response;
use Yii;

class SchoolsController extends Controller
{
    private $repository;

    public function __construct($id,  $module, DictSchoolsReadRepository $repository, $config = [])
    {
        $this->repository = $repository;
        parent::__construct($id, $module, $config);
    }

    public function actionAll($country_id, $region_id = null) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->repository->getAllSchools($region_id, $country_id)];

    }
}