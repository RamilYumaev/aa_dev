<?php

namespace operator\controllers;

use olympic\forms\WebConferenceForm;
use olympic\models\WebConference;
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
        return $this->render('index');
    }

    public function actionWebConference()
    {
        $webs = WebConference::find()->all();
        return $this->render('web-conference',['webs' => $webs]);
    }

}
