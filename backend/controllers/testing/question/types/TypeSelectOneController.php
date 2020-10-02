<?php
namespace backend\controllers\testing\question\types;

use testing\forms\question\search\QuestionSearch;
use testing\forms\question\TestQuestionTypesForm;
use testing\helpers\TestQuestionHelper;
use testing\models\TestQuestion;
use testing\services\TestQuestionService;
use yii\base\Model;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class TypeSelectOneController extends Controller
{
    private $service;
    private $type = TestQuestionHelper::TYPE_SELECT_ONE;

    public function __construct($id, $module, TestQuestionService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionCreate($olympic_id,$group_id = null)
    {
        $form = new TestQuestionTypesForm($group_id, $this->type, null, $olympic_id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->create($form, $olympic_id);
                    return $this->redirect(['index', 'olympic_id' => $olympic_id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('create', ['model' => $form]);
    }

    public function actionIndex($olympic_id)
    {
        $searchModel = new QuestionSearch($olympic_id, $this->type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'olympic_id' => $olympic_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id,$olympic_id)
    {
        $model = $this->findModel($id, $olympic_id);
        $form = new TestQuestionTypesForm(null, $this->type, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->answer = $form->isArrayMoreAnswer();
            if (Model::loadMultiple($form->answer, Yii::$app->request->post()) && Model::validateMultiple($form->answer)) {
                try {
                    $this->service->update($form);
                    return $this->redirect(['index', 'olympic_id' => $olympic_id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('update', ['model' => $form, 'question' => $model]);
    }

    public function actionView($id, $olympic_id)
    {
        $model = $this->findModel($id, $olympic_id);
        return $this->render('view', ['question' => $model]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id, $olympic_id): TestQuestion
    {
        if (($model = TestQuestion::findOne(['id'=>$id, 'type_id' => $this->type, 'olympic_id' => $olympic_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
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