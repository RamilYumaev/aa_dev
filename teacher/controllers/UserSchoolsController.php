<?php

namespace teacher\controllers;

use common\auth\forms\UserEmailForm as SchoolEmailForm;
use common\user\readRepositories\UserTeacherReadRepository;
use dictionary\models\DictSchools;
use dictionary\services\DictSchoolsService;
use olympic\services\UserSchoolService as TeacherSchoolService;
use teacher\models\searches\UserOlympicSearch;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class UserSchoolsController extends Controller
{
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
}
