<?php

namespace modules\entrant\controllers\admin;

use modules\entrant\searches\admin\EntrantInWorkSearch;
use modules\entrant\models\EntrantInWork;
use yii\filters\VerbFilter;
use yii\web\Controller;

class EntrantInWorkController extends Controller
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-data' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new EntrantInWorkSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
                'dataProvider' => $dataProvider]
        );
    }

    public function actionDelete($id){
        (EntrantInWork::findOne($id))->delete();
        return $this->redirect(['index']);
    }

}