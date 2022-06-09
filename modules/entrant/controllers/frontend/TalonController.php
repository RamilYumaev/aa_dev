<?php

namespace modules\entrant\controllers\frontend;

use modules\entrant\helpers\UserCgHelper;
use modules\entrant\models\Talons;
use olympic\models\auth\Profiles;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class TalonController extends Controller
{
    /**
     * @param $action
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if(!$this->getOperator()) {
            return $this->redirect('/');
        }
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $profiles = Profiles::findOne(['user_id' =>$this->getUserId()]);
        if(!$profiles || $profiles->isNullProfile()) {
            Yii::$app->session->setFlash('warning', 'Необходимо заполнить профиль абитуриента');
            return $this->redirect('/profile/edit');
        }
        if(!UserCgHelper::findUser($this->getUserId())) {
            Yii::$app->session->setFlash('warning', 'Необходимо выбрать конкурсные группы');
            return $this->redirect('/abiturient/anketa/step2');
        }
        $provider = new ActiveDataProvider(['query' => Talons::find()->andWhere([ 'entrant_id' => $this->getUserId()])]);

        return $this->render('index', ['provider' => $provider]);
    }

    public function actionAdd()
    {
        if(Talons::find()->andWhere(['entrant_id' => $this->getUserId(), 'date' => date('Y-m-d')])->exists()) {
            Yii::$app->session->setFlash('warning', 'У данного абитуриента есть талон на сегодня');
             return $this->redirect('index');
        }
        $model = new Talons();
        $model->date = date('Y-m-d');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->entrant_id = $this->getUserId();
            $model->status = Talons::STATUS_NEW;
            $model->save();
            return $this->redirect('index');
        }
        return $this->renderAjax('form', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        if(!$model = Talons::findOne(['id'=>$id, 'date' => date('Y-m-d')])) {
            Yii::$app->session->setFlash('error', 'Талон не найден');
            return $this->redirect('index');
        }
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect('index');
        }
        return $this->renderAjax('form', ['model' => $model]);
    }

    protected function getOperator() {
        return \Yii::$app->session->get('user.idbeforeswitch');
    }

    protected function getIdAnketa() {
        return \Yii::$app->session->get('idAnketa');
    }

    protected function getUserId() {
        return \Yii::$app->user->identity->getId();
    }
}
