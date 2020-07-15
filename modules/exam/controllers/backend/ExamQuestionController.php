<?php


namespace modules\exam\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamQuestionGroupForm;
use modules\exam\forms\question\ExamQuestionForm;
use modules\exam\forms\question\ExamQuestionNestedCreateForm;
use modules\exam\forms\question\ExamQuestionNestedUpdateForm;
use modules\exam\forms\question\ExamTypeQuestionAnswerForm;
use modules\exam\models\Exam;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\searches\ExamQuestionGroupSearch;
use modules\exam\searches\ExamQuestionSearch;
use modules\exam\searches\ExamSearch;
use modules\exam\services\ExamQuestionGroupService;
use modules\exam\services\ExamQuestionService;
use modules\exam\services\ExamService;
use testing\forms\question\TestQuestionClozeForm;
use testing\forms\question\TestQuestionClozeUpdateForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use yii\base\Model;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExamQuestionController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamQuestionSearch($this->jobEntrant);
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
        $exam = $this->findModel($id);
        return $this->render('view', [
            'exam' => $exam
        ]);
    }

    /**
     * @param $type
     * @return mixed
     */
    public function actionCreate($type)
    {
        if($type == TestQuestionHelper::TYPE_SELECT_ONE ||
            $type == TestQuestionHelper::TYPE_SELECT ||
            $type == TestQuestionHelper::TYPE_MATCHING ||
            $type == TestQuestionHelper::TYPE_ANSWER_SHORT) {
            $form = new ExamTypeQuestionAnswerForm($this->jobEntrant, null, $type);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $form->answer = $form->isArrayMoreAnswer();
                if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                    try {
                        $this->service->createAnswer($form);
                        return $this->redirect(['index']);
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
        }elseif($type == TestQuestionHelper::TYPE_ANSWER_DETAILED) {
            $form = new ExamQuestionForm($this->jobEntrant,null,['type_id' => $type]);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->create($form);
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }elseif($type == TestQuestionHelper::TYPE_CLOZE) {
                $form = new ExamQuestionNestedCreateForm($this->jobEntrant);
                if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                    $form->questProp = $form->questPropMore();
                    if (Model::loadMultiple($form->questProp, Yii::$app->request->post())
                        && Model::validateMultiple($form->questProp)) {
                        if ($form->answerClozeMore()) {
                            $form->answerCloze = $form->answerClozeMore();
                            try {
                                $this->service->createNested($form);
                                return $this->redirect(['index']);
                            } catch (\DomainException $e) {
                                Yii::$app->errorHandler->logException($e);
                                Yii::$app->session->setFlash('error', $e->getMessage());
                            }
                        }
                    }
                }
            }


        return $this->render('create', [
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
        if($model->type_id == TestQuestionHelper::TYPE_SELECT_ONE ||
            $model->type_id == TestQuestionHelper::TYPE_SELECT ||
            $model->type_id == TestQuestionHelper::TYPE_MATCHING ||
            $model->type_id == TestQuestionHelper::TYPE_ANSWER_SHORT) {
            $form = new ExamTypeQuestionAnswerForm($this->jobEntrant, $model);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $form->answer = $form->isArrayMoreAnswer();
                if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                    try {
                        $this->service->editAnswer($model->id, $form);
                        return $this->redirect(['index']);
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
        }elseif($model->type_id == TestQuestionHelper::TYPE_ANSWER_DETAILED) {
            $form = new ExamQuestionForm($this->jobEntrant, $model);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->edit($model->id, $form);
                    return $this->redirect(['index']);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }elseif($model->type_id == TestQuestionHelper::TYPE_CLOZE) {
            $form = new ExamQuestionNestedUpdateForm($this->jobEntrant,$model);
            if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                $form->questProp = $form->questPropMore();
                if (Model::loadMultiple($form->questProp, Yii::$app->request->post())
                    && Model::validateMultiple($form->questProp)) {
                    if ($form->answerClozeMore()) {
                        $form->answerCloze = $form->answerClozeMore();
                        try {
                            $this->service->updateNested($id, $form);
                            return $this->redirect(['index']);
                        } catch (\DomainException $e) {
                            Yii::$app->errorHandler->logException($e);
                            Yii::$app->session->setFlash('error', $e->getMessage());
                        }
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $form,
            'question'=> $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ExamQuestion
    {
        if (($model = ExamQuestion::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
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