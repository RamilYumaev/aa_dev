<?php
namespace backend\controllers\dod;

use common\sending\actions\SendingDeliveryStatusAction;
use common\sending\actions\SendingDodAction;
use common\sending\helpers\SendingDeliveryStatusHelper;
use dod\models\DateDod;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DodDeliveryStatusController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */

    public function actions()
    {
       return [
           'index' => [
               'class'=>SendingDeliveryStatusAction::class,
               'model'=> $this->findModel(\Yii::$app->request->get('dod_id')),
               'modelType' => SendingDeliveryStatusHelper::TYPE_DOD
           ],
           'send-href' => [
               'class'=>SendingDodAction::class,
               'model'=> $this->findModel(\Yii::$app->request->get('dod_id')),
               'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB],
       ];
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