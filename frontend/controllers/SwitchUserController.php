<?php

namespace frontend\controllers;

use common\auth\models\SwitchUser;
use common\components\JsonAjaxField;
use olympic\helpers\auth\ProfileHelper;
use yii\web\Controller;
use yii\web\Response;

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

    public function actionGetList($submittedStatus, $countryId, $regionId)
    {
        if($regionId == "")
        {
            $regionId = null;
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $array = ProfileHelper::getListForSwitch($submittedStatus, $countryId, $regionId);
        return ['result' => JsonAjaxField::dataSwitcher($array)];
    }
}