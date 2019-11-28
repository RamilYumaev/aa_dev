<?php


namespace backend\controllers\testing\question\types;


use testing\forms\question\search\QuestionSearch;
use testing\forms\question\TestQuestionEditForm;
use testing\forms\question\TestQuestionForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use testing\models\TestQuestion;
use testing\services\TestQuestionService;
use yii\base\Model;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TypeAnswerDetailedController extends Controller
{
    private $type = TestQuestionHelper::TYPE_ANSWER_DETAILED;
    private $service;
    public function __construct($id, $module, TestQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionCreate($group_id = null)
    {
        $form = new TestQuestionForm($group_id, $this->type);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->createQuestion($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        return $this->render('create', ['model' => $form]);
    }

    public function actionIndex()
    {
        $searchModel = new QuestionSearch($this->type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new TestQuestionEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                 $this->service->updateQuestion($form);
                return $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', ['model' => $form, 'question' => $model]);
    }

    public function actionView($id) {
        return $this->render('view', [
            'question' => $this->findModel($id)
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): TestQuestion
    {
        if (($model = TestQuestion::findOne(['id'=>$id, 'type_id' => $this->type])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}