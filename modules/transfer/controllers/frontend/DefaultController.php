<?php

namespace modules\transfer\controllers\frontend;

use api\client\Client;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        if(!$this->findModel()) {
            return $this->redirect(['fix']);
        }
        return $this->render('index',['userId' => $this->getUser()]);
    }

    public function actionFix() {
        $model = $this->findModel() ?? new TransferMpgu(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $isMPGU = $model->type == TransferMpgu::IN_MPGU || $model->type == TransferMpgu::INSIDE_MPGU;
//            if($isMPGU  && $model->number) {
//               $date = $this->getJson($model->number);
//            }
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    public function getJson ($number) {
        $url =  '';
        $result =  (new Client())->getData($url, ['student_record_id' => $number]);
        return $result;
    }

    protected function findModel() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
