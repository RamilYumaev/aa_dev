<?php

namespace operator\controllers\testing\trail;

use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use testing\services\TestAttemptService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TestAttemptController extends Controller
{
    private $service;

    public function __construct($id, $module, TestAttemptService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'start' => ['POST'],
                    'end' => ['POST'],
                ],
            ],
        ];
    }


    public function actionStart($test_id)
    {
        try {
            $testAttempt = $this->service->create($test_id);
            return $this->redirect(['testing/trail/test/view', 'id' => $testAttempt->test_id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEnd($test_id)
    {

        try {
            $testAttempt = $this->service->end($test_id);
            return $this->redirect(['testing/test-attempt/view', 'id' => $testAttempt->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}