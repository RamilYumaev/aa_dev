<?php
namespace modules\superservice\controllers\amqp;

use modules\exam\jobs\TestEmailJob;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionTest() {
        \Yii::$app->queue->push(new TestEmailJob());
    }
}