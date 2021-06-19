<?php

namespace modules\entrant\controllers\frontend;

use modules\entrant\models\Anketa;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{

    public function actionIndex()
    {   if(!$this->getAnketa()) {
        return $this->redirect(['anketa/step1']);
        }
        return $this->render('index');
    }

    protected function getAnketa()
    {
        return  Yii::$app->user->identity->anketa();
    }
}
