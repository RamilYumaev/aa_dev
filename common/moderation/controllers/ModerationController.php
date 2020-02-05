<?php

namespace common\moderation\controllers;

use common\moderation\models\Moderation;
use common\moderation\forms\ModerationMessageForm;
use common\moderation\services\ModerationService;
use kartik\form\ActiveForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ModerationController extends Controller
{
    private $service;

    public function __construct($id, $module, ModerationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(['query'=> Moderation::find()]);

        return $this->render('@common/moderation/views/moderation/index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     * @param integer $id
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('@common/moderation/views/moderation/view', [
            'moderation' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionReject($id)
    {
        $form = new ModerationMessageForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reject($id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('@common/moderation/views/moderation/reject', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionTake($id)
    {
        try {
            $this->service->take($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Moderation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Moderation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
