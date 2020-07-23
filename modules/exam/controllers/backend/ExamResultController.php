<?php


namespace modules\exam\controllers\backend;

use kartik\form\ActiveForm;
use modules\exam\forms\ExamFinalMarkResultForm;
use modules\exam\models\Exam;
use modules\exam\models\ExamResult;
use modules\exam\services\ExamResultService;
use testing\forms\AddFinalMarkResultForm;
use testing\models\TestResult;
use testing\services\TestResultService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExamResultController extends Controller
{
    private $service;

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

    public function __construct($id, $module, ExamResultService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($attempt_id, $question_id,  $tq_id)
    {
        $model = $this->findModel($attempt_id, $question_id,  $tq_id);
        $form = new ExamFinalMarkResultForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($attempt_id, $question_id, $tq_id, $form);
                return $this->redirect(['exam-attempt/view', 'id' => $model->attempt_id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param $attempt_id
     * @param $question_id
     * @param $tq_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($attempt_id, $question_id, $tq_id): ExamResult
    {
        if (($model = ExamResult::findOne(['attempt_id' => $attempt_id, 'question_id'=> $question_id, 'tq_id' => $tq_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}