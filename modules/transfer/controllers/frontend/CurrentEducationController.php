<?php

namespace modules\transfer\controllers\frontend;

use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\CurrentEducation;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;

class CurrentEducationController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ]
        ];
    }


    public function actionIndex() {
        if($this->findTransfer()->isMpgu()) {
            \Yii::$app->session->setFlash('warning', 'Страница недоступна');
            return $this->redirect(['default/index']);
        }
        $model = $this->findModel() ?? new CurrentEducation(['user_id' => $this->getUser()]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обновлено');
                    return $this->redirect(['current-education-info/index']);
            }
        }
        return  $this->render('form',['model' => $model ]);
    }

    protected function findModel() {
        return CurrentEducation::findOne(['user_id'=> $this->getUser()]);
    }

    protected function findTransfer() {
        return TransferMpgu::findOne(['user_id'=> $this->getUser()]);
    }

    protected function getUser() {
        return  \Yii::$app->user->identity->getId();
    }


}
