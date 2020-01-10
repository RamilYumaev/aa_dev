<?php


namespace backend\controllers\testing;

use olympic\repositories\OlimpicListRepository;
use testing\actions\traits\TestAttemptActionsTrait;
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
        try {
            return $this->render('view', [
                'attempt' => $this->findModel($id),
            ]);
        } catch (NotFoundHttpException $e) {
        }
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
        try {
            $this->service->remove($id);
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
    protected function findModel($id): TestAttempt
    {
        if (($model = TestAttempt::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}