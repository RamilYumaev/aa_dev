<?php

namespace operator\controllers\testing\question\types;


use olympic\helpers\OlympicHelper;
use olympic\repositories\OlimpicListRepository;
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
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

class TypeAnswerUrlController extends Controller
{
    private $type = TestQuestionHelper::TYPE_URL;
    private $olimpicListRepository;
    private $service;
    public function __construct($id, $module,  TestQuestionService $service, OlimpicListRepository $olimpicListRepository, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->olimpicListRepository = $olimpicListRepository;
    }

    public function actionCreate($olympic_id, $group_id = null)
    {
        $this->olimpicListRepository->getManager($olympic_id);
        $form = new TestQuestionForm($group_id, $this->type, $olympic_id);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                try {
                    $this->service->createQuestion($form, $olympic_id);
                    return $this->redirect(['index', 'olympic_id' => $olympic_id]);
                } catch (\DomainException $e) {
                    Yii::$app->errorHandler->logException($e);
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        return $this->render('@backend/views/testing/question/types/type-answer-url/create', ['model' => $form]);
    }

    public function actionIndex($olympic_id)
    {
        try {
            $this->olimpicListRepository->getManager($olympic_id);
        } catch (HttpException $e) {
        }
        $searchModel = new QuestionSearch($olympic_id, $this->type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@backend/views/testing/question/types/type-answer-url/index', [
            'olympic_id' => $olympic_id,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id, $olympic_id)
    {
        $this->olimpicListRepository->getManager($olympic_id);
        $model = $this->findModel($id, $olympic_id);
        $form = new TestQuestionEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                 $this->service->updateQuestion($form);
                return $this->redirect(['index', 'olympic_id' => $olympic_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('@backend/views/testing/question/types/type-answer-url/update', ['model' => $form, 'question' => $model]);
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

}