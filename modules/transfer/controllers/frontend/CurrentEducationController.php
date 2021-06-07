<?php

namespace modules\transfer\controllers\frontend;

use api\client\Client;
use modules\transfer\models\CurrentEducation;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;

class CurrentEducationController extends Controller
{
    public function actionIndex() {
        $model = $this->findModel() ?? new CurrentEducation(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                if(!$model->current_analog) {
                    return $this->redirect(['current-education/index']);
                }
                return $this->redirect(['default/index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    protected function findModel() {
        return CurrentEducation::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
