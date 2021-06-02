<?php

namespace modules\transfer\controllers\frontend;

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
            $model->number = $model->user_id.'-'.$model->type.'-'.date('dmy');
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    protected function findModel() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
