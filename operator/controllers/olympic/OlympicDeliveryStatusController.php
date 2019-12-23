<?php
namespace operator\controllers\olympic;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OlympicDeliveryStatusController extends Controller
{
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($olympic_id, $typeSending)
    {
        $olympic = $this->findModel($olympic_id);
        $model =  SendingDeliveryStatus::find()->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
            ->typeSending($typeSending)->value($olympic->id);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->render('@backend/views/olympic/olympic-delivery-status/index', [
            'dataProvider' => $dataProvider,
            'olympic' => $olympic,
            'type' => $typeSending
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    protected function findModel($id): OlimpicList
    {
        if (($model = OlimpicList::find()->where(['id'=>$id,'olimpic_id'=>OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}