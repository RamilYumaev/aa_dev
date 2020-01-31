<?php

namespace backend\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'about'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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


    public function actionAbout()
    {

        $this->setHttpHeaders();
        //send content as attachment with filename my-export.xlsx and proper mime type
        \moonland\phpexcel\Excel::widget([
            'mode' => 'export',
            'models' => \olympic\models\Olympic::find()->all(),
            'columns' => [
                'id', 'name'
            ],
            'headers' => [
                'id' => 'Date Created Content',
            ],
        ]);

        //return $this->render('index');
    }

    protected function setHttpHeaders()
    {
        header("Cache-Control: no-cache");
        header("Pragma: no-cache");
        header("Content-Type: application/xls; charset=utf-8");
        header("Content-Disposition: attachment; filename=rr.xls");
        header("Expires: 0");

    }

}
