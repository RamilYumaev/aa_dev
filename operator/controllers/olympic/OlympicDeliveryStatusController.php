<?php
namespace operator\controllers\olympic;

use common\sending\actions\SendingDeliveryStatusAction;
use common\sending\actions\SendingAction;
use common\sending\helpers\SendingDeliveryStatusHelper;
use olympic\helpers\OlympicHelper;
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
                'class'=>SendingAction::class,
                'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id')),
                'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA
            ],
            'send-preliminary-result' => [
                'class'=>SendingAction::class,
                'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id')),
                'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY
            ],
            'send-invitation' => [
                'class'=>SendingAction::class,
                'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id')),
                'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_INVITATION_AFTER_DISTANCE_TOUR
            ],
            'send-invitation-first' => [
                'class'=>SendingAction::class,
                'olympicModel'=> $this->findModel(\Yii::$app->request->get('olympic_id')),
                'typeSending' => SendingDeliveryStatusHelper::TYPE_SEND_INVITATION
            ]
        ];
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