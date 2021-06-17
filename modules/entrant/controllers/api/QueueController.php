<?php

namespace modules\entrant\controllers\api;


use yii\rest\Controller;

class QueueController extends Controller
{
    public function actionIndex()
    {
        return ['message' => "Okay"];
    }

}