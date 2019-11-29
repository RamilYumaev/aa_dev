<?php


namespace backend\controllers\testing;


use testing\forms\TestAndQuestionsForm;
use testing\repositories\TestRepository;
use testing\services\TestAndQuestionsService;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class TestAndQuestionsController extends Controller
{
    private $service;
    private $testRepository;

    public function __construct($id, $module, TestAndQuestionsService $service, TestRepository $testRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testRepository = $testRepository;
    }

    /**
     * @return mixed
     */
    public function actionAddQuestion($test_id)
    {
        $test = $this->testRepository->get($test_id);
        $form = new TestAndQuestionsForm($test, false);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addQuestions($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add-question', [
            'model' => $form,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionAddGroup($test_id)
    {
        $test = $this->testRepository->get($test_id);
        $form = new TestAndQuestionsForm($test, true);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addGroup($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add-group', [
            'model' => $form,
        ]);
    }
}