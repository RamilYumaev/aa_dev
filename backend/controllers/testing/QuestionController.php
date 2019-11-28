<?php
namespace backend\controllers\testing;
use yii\web\Controller;

class QuestionController extends Controller
{

    public function actionIndex() {
        return $this->render('index');
    }

}