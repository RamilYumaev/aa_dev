<?php

namespace teacher\controllers;

use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
use teacher\models\UserTeacherJob;
use yii\data\ActiveDataProvider;
use yii\web\Controller;


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
        $dataProvider = new ActiveDataProvider(['query' => UserTeacherJob::find()->diploma()]);
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

}
