<?php
namespace modules\literature\controllers\frontend;

use modules\literature\models\LiteratureOlympic;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            $userId = Yii::$app->user->identity->getId();
            if(LiteratureOlympic::findOne(['user_id'=> $userId])) {
               return $this->render('index');
            }
        }
        return $this->render('index');
}
