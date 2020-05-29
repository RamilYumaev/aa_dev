<?php

namespace frontend\controllers;

use common\auth\models\SwitchUser;
use yii\web\Controller;

class SwitchUserController extends Controller
{

    public function actionIndex()
    {
        $model = new SwitchUser();
        if ($model->load(\Yii::$app->request->post())) {
            try {
                \Yii::$app->user->identity->switchUser($model->userId);
                return $this->goHome();
            } catch (\Exception $e) {
                \Yii::$app->session->setFlash('error', $model->errors);
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    public function actionComeBack()
    {
        if ($adminUser = \Yii::$app->session->get('user.idbeforeswitch')) {
            \Yii::$app->user->identity->switchUser($adminUser);
            \Yii::$app->session->remove('user.idbeforeswitch');
        } else {
            \Yii::$app->session->setFlash('error', 'Ошибка. Потерян идентификационный ключ администратора.');
            return $this->redirect('/account/logout');
        }
        return $this->goHome();
    }

}