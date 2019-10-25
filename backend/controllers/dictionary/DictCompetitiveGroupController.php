<?php


namespace backend\controllers\dictionary;

use Yii;
use olympic\forms\dictionary\search\DictCompetitiveGroupSearch;
use yii\web\Controller;

class DictCompetitiveGroupController extends Controller
{

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictCompetitiveGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}