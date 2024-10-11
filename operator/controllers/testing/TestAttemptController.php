<?php

namespace operator\controllers\testing;

use olympic\models\OlimpicList;
use olympic\repositories\OlimpicListRepository;
use testing\actions\traits\TestAttemptActionsTrait;
use testing\helpers\TestAttemptHelper;
use testing\models\TestAttempt;
use testing\models\TestResult;
use testing\repositories\TestRepository;
use testing\services\TestAttemptService;
use yii\base\ExitException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TestAttemptController extends Controller
{
    use TestAttemptActionsTrait;
    private $service;
    private $testRepository;
    private $olimpicListRepository;

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

    public function __construct($id, $module, TestAttemptService $service, TestRepository $testRepository,
                                OlimpicListRepository $olimpicListRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testRepository = $testRepository;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public function actionIndex($test_id)
    {
        $test = $this->testRepository->get($test_id);
        $olympic = $this->olimpicListRepository->get($test->olimpic_id);
        $this->disabled($olympic, $test_id);
        return $this->render('@backend/views/testing/test-attempt/index', [
            'test' => $test,
            'olympic' => $olympic]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('@backend/views/testing/test-attempt/view', [
            'attempt' => $model,
        ]);
    }

    public function actionEndDistTour($test_id, $olympic_id)
    {
        try {
            $this->service->finish($test_id, $olympic_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEndDistTourAll($olympic_id)
    {
        try {
            $this->service->finishAll($olympic_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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
        return $this->redirect(['index','test_id' => $model->test_id]);
    }

    public function actionUpdateTestResult($testId)
    {
        $incompleteAttempts = TestAttempt::find()
            ->andWhere(['test_id' => $testId])
            ->andWhere(['status' => TestAttemptHelper::NO_END_TEST])
            ->all();

        foreach ($incompleteAttempts as $attempt) {
            $testResult = TestResult::find()->where(['attempt_id' => $attempt->id])->sum('mark');
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

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): TestAttempt
    {
        if (($model = TestAttempt::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function disabled(OlimpicList $olimpicList, $test_id) {
        if($olimpicList->disabled_a || $olimpicList->is_volunteering) {
            Yii::$app->session->setFlash('error', "Страница находится на доработке...");
            Yii::$app->getResponse()->redirect(['testing/test/view', 'id' => $test_id]);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
    }
}