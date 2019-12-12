<?php


namespace backend\controllers\testing;

use testing\models\TestAttempt;
use testing\repositories\TestRepository;
use testing\services\TestAndQuestionsService;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TestResultController extends Controller
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

    public function __construct($id, $module, TestAndQuestionsService $service, TestRepository $testRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testRepository = $testRepository;
    }

    public function actionIndex($test_id)
    {
        return $this->render('view', [
                'attempt' => $test_id,
            ]);
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