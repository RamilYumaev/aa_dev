<?php

namespace common\user\controllers;

use common\auth\forms\DeclinationFioForm;
use common\auth\models\DeclinationFio;
use common\auth\services\DeclinationService;
use yii\bootstrap\ActiveForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class DeclinationController extends Controller
{
    private $service;


    public function __construct($id,  $module, DeclinationService $service,
                                $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
        $this->viewPath = '@common/user/views/declination';
    }

    public function behaviors(){
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }


    /*
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
   */

    public function actionUpdate($id) {
        $model = $this->find($id);
        $form = new DeclinationFioForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id,$form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['/profile/edit']);
        }
        return $this->renderAjax('update',['model' => $form]);
    }
    /*
      * @param $id
      * @return mixed
      * @throws NotFoundHttpException
    */
    protected function find($id)
    {
        if (($model = DeclinationFio::findOne(['id'=>$id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }
}