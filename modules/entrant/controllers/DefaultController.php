<?php

namespace modules\entrant\controllers;

use yii\captcha\CaptchaAction;
use yii\web\Controller;
use yii\web\ErrorAction;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
