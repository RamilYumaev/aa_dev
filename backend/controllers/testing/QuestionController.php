<?php


namespace backend\controllers\testing;

use testing\models\TestQuestion;
use testing\services\TestQuestionService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class QuestionController extends Controller
{

    public function actionIndex() {

        $query = TestQuestion::find()->orderBy(['id'=> SORT_DESC]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

}