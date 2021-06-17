<?php

namespace modules\transfer\controllers\frontend;

use api\client\Client;
use modules\transfer\behaviors\RedirectBehavior;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\PacketDocumentUser;
use modules\transfer\models\TransferMpgu;
use Yii;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ],
            [
                'class'=> RedirectBehavior::class,
                'ids'=>['fix' ]
            ],

        ];
    }

    public function actionIndex()
    {
        return $this->render('index',['transfer' => $this->findModel()]);
    }

    public function actionFix() {
        $model = $this->findModel() ?? new TransferMpgu(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->isMpgu() && $model->number) {
               $data = $this->getJson($model->number);
                if(key_exists('current_status_id', $data)) {
                    $model->current_status = $data['current_status_id'];
                }
                else {
                    \Yii::$app->session->setFlash('warning',  $data['error']);
                    return $this->redirect(['fix']);
                }
            }else {
                $model->current_status = $model::STATUS_ACTIVE;
            }
            if($model->save()) {
                if(!in_array($model->current_status, $model::ACTIVE)) {
                    \Yii::$app->session->setFlash('danger',
                        key_exists($model->current_status, $model->listMessage()) ?
                            $model->listMessage()[$model->current_status] : 'Попробуйте в другой раз');
                    return $this->redirect(['fix']);
                }
                if(PacketDocumentUser::findOne(['user_id' => $this->getUser()])) {
                PacketDocumentUser::deleteAll(['user_id' => $this->getUser()]);
                }

                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    public function getJson ($number) {
        $url =  'external/incoming-abiturient/get-student-info';
        $array['student_record_id'] = $number;
        $array['token'] = \md5($number . \date('Y.m.d').Yii::$app->params['keyAisCompetitiveList']);
        $result =  (new Client(Yii::$app->params['ais_competitive']))->getData($url, $array);
        return $result;
    }

    protected function findModel() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
