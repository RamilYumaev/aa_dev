<?php
namespace backend\controllers\olympic;

use common\sending\actions\SendingDeliveryStatusAction;
use common\sending\actions\SendingDiplomaAction;
use olympic\models\OlimpicList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class OlympicDeliveryStatusController extends Controller
{
    /**
     * @throws NotFoundHttpException
     */

    public function actions()
    {
       return [
           'index' => [
               'class'=>SendingDeliveryStatusAction::class,
               'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id'))],
           'send-diploma' => [
               'class'=>SendingDiplomaAction::class,
               'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id')),
           ]];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlimpicList
    {
        if (($model = OlimpicList::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}