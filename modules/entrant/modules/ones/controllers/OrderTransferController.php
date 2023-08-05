<?php
namespace modules\entrant\modules\ones\controllers;

use modules\entrant\modules\ones\forms\search\OrderTransferSearch;
use modules\entrant\modules\ones\model\OrderTransferOnes;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OrderTransferController extends Controller
{
    public function behaviors(): array
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderTransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OrderTransferOnes();
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

//    /**
//     * @param $id
//     * @return string
//     * @throws NotFoundHttpException
//     */
//    public function actionView($id)
//    {
//        $model = $this->findModel($id);
//        $searchModel = new CompetitiveListSearch(null, $model->snils_or_id);
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//        return $this->render('view', [
//            'model' => $model,
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
//    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

//    /**
//     * @param integer $id
//     * @return mixed
//     * @throws NotFoundHttpException
//     * @throws \yii\db\StaleObjectException
//     */
//    public function actionDelete($id)
//    {
//        $model = $this->findModel($id);
//        $model->delete();
//        return $this->redirect(['index']);
//    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OrderTransferOnes
    {
        if (($model = OrderTransferOnes::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
