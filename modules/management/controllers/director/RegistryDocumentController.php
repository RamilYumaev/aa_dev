<?php

namespace modules\management\controllers\director;


use modules\management\models\Task;
use modules\management\searches\RegistryDocumentSearch;
use Yii;
use yii\web\Controller;

class RegistryDocumentController extends Controller
{
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RegistryDocumentSearch(new Task());
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
}