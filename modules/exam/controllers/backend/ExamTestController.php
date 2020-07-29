<?php

namespace modules\exam\controllers\backend;
use modules\exam\forms\ExamQuestionInTestTableMarkForm;
use modules\exam\forms\ExamTestForm;
use modules\exam\models\ExamQuestionInTest;
use modules\exam\models\ExamTest;
use modules\exam\services\ExamQuestionInTestService;
use modules\exam\services\ExamTestService;
use testing\forms\search\TestSearch;
use testing\forms\TestAndQuestionsTableMarkForm;
use testing\models\TestAndQuestions;
use testing\services\TestAndQuestionsService;
use testing\services\TestService;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use Yii;

class ExamTestController extends Controller
{
    private $service;
    private $examQuestionInTestService;

    public function __construct($id, $module,
                                ExamTestService $service,
                                ExamQuestionInTestService $examQuestionInTestService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->examQuestionInTestService = $examQuestionInTestService;
    }

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

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modelExamQuestionInTest= ExamQuestionInTest::find()->where(['test_id'=> $model->id])->indexBy('id')->all();
        $examQuestionInTest = new ExamQuestionInTestTableMarkForm($modelExamQuestionInTest);
        if (Model::loadMultiple($examQuestionInTest->arrayMark, Yii::$app->request->post())) {
            try {
                $this->examQuestionInTestService->addMark($examQuestionInTest);
                return $this->redirect(['exam/view','id'=> $model->exam_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }

        }

        return $this->render('view', [
            'test' => $model,
            'examQuestionInTest' =>$examQuestionInTest
        ]);
    }

    /**
     * @param $exam_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionCreate($exam_id)
    {
        $form = new ExamTestForm(null,['exam_id' => $exam_id]);

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
        return $this->renderAjax('form', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new ExamTestForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('form', [
            'model' => $form,
            'test' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ExamTest
    {
        if (($model = ExamTest::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionStart($id)
    {
        try {
            $this->service->start($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionEnd($id)
    {
        try {
            $this->service->end($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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