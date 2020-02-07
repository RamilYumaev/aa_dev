<?php

namespace teacher\controllers;

use common\auth\forms\UserEmailForm as SchoolEmailForm;
use common\user\readRepositories\UserTeacherReadRepository;
use dictionary\models\DictSchools;
use dictionary\services\DictSchoolsService;
use olympic\repositories\OlimpicListRepository;
use olympic\services\OlimpicListService;
use olympic\services\UserOlimpiadsService;
use olympic\services\UserSchoolService as TeacherSchoolService;
use teacher\models\searches\UserOlympicSearch;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class UserSchoolsController extends Controller
{

    private $service;
    private $listService;

    public function __construct($id, $module,
                                UserOlimpiadsService $olimpiadsService,
                                OlimpicListService $listService,
                                $config = [])
    {
        $this->service = $olimpiadsService;
        $this->listService = $listService;
        parent::__construct($id, $module, $config);
    }
    /*
    *
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserOlympicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $olympic
     * @return array
     */

    public function actionUsers($olympic)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['users' => $this->service->allUsersAjax($olympic)];

    }

    /**
     * @param $year
     * @return array
     */

    public function actionOlympics($year)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['olympics' => $this->listService->allOlympicsAjax($year)];

    }
}
