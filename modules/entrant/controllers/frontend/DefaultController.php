<?php

namespace modules\entrant\controllers\frontend;

use modules\entrant\helpers\PostDocumentHelper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use Yii;

class DefaultController extends Controller
{
    /**
     * @param $action
     * @return \yii\web\Response
     * @throws \yii\base\ExitException
     */

    public function beforeAction($action)
    {
        if(!$this->getAnketa()) {
            Yii::$app->getResponse()->redirect(['abiturient/anketa/step1']);
            Yii::$app->end();
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCse()
    {
        return $this->render('cse');
    }

    private function getAnketa()
    {
        return  Yii::$app->user->identity->anketa();
    }
}
