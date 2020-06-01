<?php


namespace backend\controllers\testing;

use olympic\models\OlimpicList;
use olympic\repositories\OlimpicListRepository;
use testing\actions\traits\TestAttemptActionsTrait;
use testing\models\Test;
use testing\models\TestAttempt;
use testing\repositories\TestRepository;
use testing\services\TestAndQuestionsService;
use testing\services\TestAttemptService;
use yii\filters\VerbFilter;
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

    public function __construct($id, $module, TestAttemptService $service,
                                TestRepository $testRepository, OlimpicListRepository $olimpicListRepository, $config = [])
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
        return $this->render('index', [
            'test' => $test,
            'olympic' => $olympic]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'attempt' => $model,]);
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

    public function actionUpdateAttempt($testId)
    {
        $test = Test::find()->andWhere(['id' => $testId])->one();

        $olympic = OlimpicList::find()->andWhere(['id' => $test->olimpic_id])->one();

        if (!$test) {
            \Yii::$app->session->setFlash('error', 'Не найден тест');
            return $this->redirect(\Yii::$app->request->referrer);
        }

        $allTestAttempt = TestAttempt::find()->andWhere(['test_id' => $test->id])->all();

        foreach ($allTestAttempt as $attempt) {
            $attempt->end = $olympic->date_time_finish_reg;
            if (!$attempt->save()) {
                \Yii::$app->session->setFlash("error",
                    "Ошибка во время сохранения даты окончания попытки $attempt->id");
                return $this->redirect(\Yii::$app->request->referrer);
            };
        }

        \Yii::$app->session->setFlash("success",
            "Успешно обновлена дата " . count($allTestAttempt) . " попытки(-ок)");
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


}