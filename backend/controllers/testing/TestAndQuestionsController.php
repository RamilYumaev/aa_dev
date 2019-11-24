<?php


namespace backend\controllers\testing;


use testing\forms\TestAndQuestionsForm;
use testing\services\TestAndQuestionsService;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class TestAndQuestionsController extends Controller
{
    private $service;

    public function __construct($id, $module, TestAndQuestionsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionCreate($test_id, $test_group_id, $question_group_id)
    {
        $form = new TestAndQuestionsForm($test_id, $test_group_id, $question_group_id);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('create', [
            'model' => $form,
        ]);
    }
}