<?php


namespace backend\controllers\testing;

use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionTypesFileForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use testing\services\TestQuestionService;
use yii\base\Model;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;

class QuestionController extends Controller
{
    private $service;

    public function __construct($id, $module, TestQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionTypeSelect($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, TestQuestionHelper::TYPE_SELECT);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->create($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('type-select', ['model' => $form]);
    }

    public function actionTypeSelectOne($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, TestQuestionHelper::TYPE_SELECT_ONE);
        if ($form->load(Yii::$app->request->post())) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->create($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('type-select-one', ['model' => $form]);
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionTypeAnswerShort($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, TestQuestionHelper::TYPE_ANSWER_SHORT);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->create($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('type-answer-short', ['model' => $form]);
    }

    public function actionTypeAnswerDetailed($group_id = null)
    {
        $form = new TestQuestionForm($group_id, TestQuestionHelper::TYPE_ANSWER_DETAILED);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createQuestion($form);
                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('type-answer-detailed', ['model' => $form]);
    }

    public function actionTypeMatching($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, TestQuestionHelper::TYPE_MATCHING);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->create($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('type-matching', ['model' => $form]);
    }

    public function actionTypeCloze($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, TestQuestionHelper::TYPE_CLOZE);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                return $this->renderContent(Html::tag('pre',
                    VarDumper::dumpAsString(
                        $form->selectAnswer
                    )));
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('type-cloze', ['model' => $form]);
    }

    public function actionTypeFiles($group_id = null)
    {
        $form = new TestQuestionTypesFileForm($group_id, TestQuestionHelper::TYPE_FILE);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createTypeFile($form);
                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('type-files', ['model' => $form]);
    }





}