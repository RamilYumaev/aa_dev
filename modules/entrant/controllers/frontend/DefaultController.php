<?php

namespace modules\entrant\controllers\frontend;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCse()
    {
        return $this->render('cse');
    }
}
