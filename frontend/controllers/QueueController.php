<?php
namespace frontend\controllers;

use yii\web\Controller;


class QueueController extends Controller
{
    public  $layout = 'queue';

    public function actionIndex()
    {
        return $this->render('index', [
            'time' => date('H:i:s'),
        ]);
    }
}