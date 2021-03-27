<?php

namespace backend\controllers\dod;

use dod\models\DateDod;
use dod\models\UserDod;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UserDodController extends Controller
{

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($id)
    {
        $dod = $this->findModel($id);
        $model = $this->getAllUserDod($dod);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dod' => $dod
        ]);
    }


    private function getAllUserDod(DateDod $dod)
    {
        return UserDod::find()->where(['dod_id' => $dod->id]);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DateDod
    {
        if (($model = DateDod::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}