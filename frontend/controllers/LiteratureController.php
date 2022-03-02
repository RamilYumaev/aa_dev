<?php
namespace frontend\controllers;

use yii\web\Controller;

class LiteratureController extends Controller {
    public function actionIndex()
    {
        return $this->render('index');
    }
}