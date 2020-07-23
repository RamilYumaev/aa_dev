<?php


namespace modules\exam\controllers\backend;

use modules\exam\models\ExamAttempt;
use modules\exam\models\ExamResult;
use modules\exam\repositories\ExamTestRepository;
use modules\exam\services\ExamAttemptService;
use olympic\models\OlimpicList;
use olympic\repositories\OlimpicListRepository;
use testing\actions\traits\TestAttemptActionsTrait;
use testing\helpers\TestAttemptHelper;
use testing\models\Test;
use testing\models\TestAttempt;
use testing\models\TestResult;
use testing\repositories\TestRepository;
use testing\services\TestAndQuestionsService;
use testing\services\TestAttemptService;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ExamAttemptController extends Controller
{

    private $service;
    private $testRepository;

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function __construct($id, $module, ExamAttemptService $service,
                                ExamTestRepository $testRepository,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testRepository = $testRepository;
    }

    public function actionIndex($test_id)
    {
        $test = $this->testRepository->get($test_id);
        return $this->render('index', [
            'test' => $test]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'attempt' => $model,]);
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index', 'test_id' => $model->test_id]);
    }

    public function actionUpdateTestResult($testId)
    {
        $incompleteAttempts = ExamAttempt::find()
            ->andWhere(['test_id' => $testId])
            ->andWhere(['status' => TestAttemptHelper::NO_END_TEST])
            ->all();

        foreach ($incompleteAttempts as $attempt) {
            $testResult = ExamResult::find()->where(['attempt_id' => $attempt->id])->sum('mark');
            $attempt->seStatus(TestAttemptHelper::END_TEST);
            $attempt->edit($testResult);
            if (!$attempt->save()) {
                $error = Json::encode($attempt->errors);
                Yii::$app->session->setFlash('error', Json::decode($error));
                return $this->redirect(\Yii::$app->request->referrer);
            }
        }
        \Yii::$app->session
            ->setFlash('success', "Результаты незавершенных попыток подсчитаны и сохраннены. Все попытки завершены");
        return $this->redirect(\Yii::$app->request->referrer);


    }

    public function actionStart($test_id)
    {
        try {
            $testAttempt = $this->service->createDefault($test_id);
            return $this->redirect(['test/view', 'id' => $testAttempt->test_id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionPauseAttempt($id)
    {
        try {
            $this->service->pause($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionStartAttempt($id)
    {
        try {
           $this->service->start($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionEnd($test_id)
    {
        try {
            $testAttempt = $this->service->endDefault($test_id);
            return $this->redirect(['exam-attempt/view', 'id'=> $testAttempt->id]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ExamAttempt
    {
        if (($model = ExamAttempt::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}