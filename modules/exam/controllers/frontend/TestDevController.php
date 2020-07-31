<?php


namespace modules\exam\controllers\frontend;

use Yii;
use yii\web\Controller;

class TestDevController extends Controller
{
    private $service;


    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');

    }
}