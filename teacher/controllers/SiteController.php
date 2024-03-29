<?php

namespace teacher\controllers;

use dictionary\models\DictSchoolsReport;
use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
use teacher\helpers\TeacherClassUserHelper;
use teacher\models\TeacherClassUser;
use teacher\models\UserTeacherJob;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query' => TeacherClassUser::find()->andWhere(
            ['user_id'=> \Yii::$app->user->identity->getId(), 'status'=> TeacherClassUserHelper::ACTIVE])]);
        return $this->render('index', ['dataProvider'=> $dataProvider]);
    }

}
