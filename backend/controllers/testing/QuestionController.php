<?php


namespace backend\controllers\testing;

use testing\services\AnswersService;
use testing\services\TestQuestionService;
use yii\web\Controller;
use Yii;

class QuestionController extends Controller
{

    private $service;

    public function __construct($id, $module, AnswersService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex() {
        try {
            $this->service->create();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->render('index');
    }

}