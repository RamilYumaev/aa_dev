<?php

namespace modules\transfer\controllers\frontend;

use modules\transfer\models\CurrentEducationInfo;
use yii\web\Controller;

class CurrentEducationInfoController extends Controller
{
    public function actionIndex() {
        $model = $this->findModel() ?? new CurrentEducationInfo(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обнолено');
                return $this->redirect(['index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    protected function findModel() {
        return CurrentEducationInfo::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }
}
