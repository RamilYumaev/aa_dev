<?php

namespace modules\exam\controllers\frontend;

use common\helpers\FlashMessages;
use frontend\components\UserNoEmail;
use modules\exam\models\ExamTest;
use modules\exam\services\ExamAttemptService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ExamAttemptController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamAttemptService $service, $config = [])
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

    /**
     * @param $test_id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionStart($test_id)
    {
        $examTestModel = $this->findModel($test_id);
        try {
            $testAttempt = $this->service->create($examTestModel, $this->getUserId());
            return $this->redirect(['exam-test/view', 'id' => $testAttempt->test_id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $test_id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionEnd($test_id)
    {
        $examTestModel = $this->findModel($test_id);
        try {
            $this->service->end($examTestModel, $this->getUserId());
            return $this->redirect(['default/index']);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = ExamTest::findOne($id)) !== null && $model->active()) {
            return $model;
        }
        throw new NotFoundHttpException(FlashMessages::get()["notFoundHttpException"]);
    }

}

