<?php


namespace backend\controllers\testing\question\types;


use testing\forms\question\search\QuestionSearch;
use testing\forms\question\TestQuestionClozeForm;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use testing\models\TestQuestion;
use testing\services\TestQuestionService;
use yii\base\Model;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TypeAnswerShortController extends Controller
{
    private $type = TestQuestionHelper::TYPE_ANSWER_SHORT;
    private $service;

    public function __construct($id, $module, TestQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
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

    public function actionCreate($group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, $this->type);
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
        return $this->render('create', ['model' => $form]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new TestQuestionTypesForm(null, $this->type, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->update($form);
                    return $this->redirect('index');
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
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