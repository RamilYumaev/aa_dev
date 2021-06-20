<?php

namespace frontend\controllers;

use common\auth\models\SwitchUser;
use common\components\JsonAjaxField;
use frontend\search\Profile;
use olympic\helpers\auth\ProfileHelper;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

class SwitchUserController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'get-list', 'by-user-id'],
                        'allow' => true,
                        'roles' => ['call-center'],
                    ],
                    [
                        'actions' => ['come-back'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $model = new Profile();

        $model->load(\Yii::$app->request->queryParams);
        return $this->render('index', ['model' => $model]);
    }

    public function actionByUserId($id)
    {
        \Yii::warning("в сессии ".\Yii::$app->session->get('user.idbeforeswitch'));
        try {
            \Yii::$app->user->identity->switchUser($id);
            return $this->goHome();
        } catch (\Exception $e) {
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->goHome();
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
        if ($regionId == "") {
            $regionId = null;
        }
        \Yii::$app->response->format = Response::FORMAT_JSON;
        $array = ProfileHelper::getListForSwitch($submittedStatus, $countryId, $regionId);
        return ['result' => JsonAjaxField::dataSwitcher($array)];
    }

}