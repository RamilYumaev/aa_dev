<?php


namespace modules\exam\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\exam\forms\ExamQuestionInTestForm;
use modules\exam\repositories\ExamTestRepository;
use modules\exam\services\ExamQuestionInTestService;
use testing\repositories\TestRepository;
use yii\base\ExitException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\Response;
use yii\bootstrap\ActiveForm;

class ExamQuestionInTestController extends Controller
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

    public function __construct($id, $module, ExamQuestionInTestService $service, ExamTestRepository $testRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->testRepository = $testRepository;
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    public function beforeAction($event)
    {
        if(!$this->jobEntrant->isCategoryExam()) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function actionAddQuestion($test_id)
    {
        $test = $this->testRepository->get($test_id);
        $form = new ExamQuestionInTestForm( $test, false);
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
        $form = new ExamQuestionInTestForm($test, true);
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

    /**
     * @param integer $id
     * @return mixed
     */
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
}