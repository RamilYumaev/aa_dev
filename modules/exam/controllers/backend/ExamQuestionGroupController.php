<?php


namespace modules\exam\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamQuestionGroupForm;
use modules\exam\models\Exam;
use modules\exam\models\ExamQuestionGroup;
use modules\exam\searches\ExamQuestionGroupSearch;
use modules\exam\searches\ExamSearch;
use modules\exam\services\ExamQuestionGroupService;
use modules\exam\services\ExamService;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExamQuestionGroupController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamQuestionGroupService $service, $config = [])
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
    public function actionIndex()
    {
        $searchModel = new ExamQuestionGroupSearch($this->jobEntrant);
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
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new ExamQuestionGroupForm($this->jobEntrant,null);
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
        $form = new ExamQuestionGroupForm($this->jobEntrant, $model);
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

    public function actionAll($discipline)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->service->getAll($discipline)];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ExamQuestionGroup
    {
        if (($model = ExamQuestionGroup::findOne($id)) !== null) {
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