<?php


namespace modules\exam\controllers\admin;


use common\components\TbsWrapper;
use modules\exam\forms\ExamDateReserveForm;
use modules\exam\forms\ExamSrcBBBForm;
use modules\exam\forms\ExamStatementForm;
use modules\exam\forms\ExamStatementMessageForm;
use modules\exam\forms\ExamStatementProctorForm;
use modules\exam\jobs\StatementExamJob;
use modules\exam\models\ExamStatement;
use modules\exam\searches\admin\ExamStatementAdminSearch;
use modules\exam\searches\admin\ExamStatementSearch;
use modules\exam\services\ExamStatementService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ExamStatementController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamStatementService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamStatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionViolation()
    {
        $searchModel = new ExamStatementSearch(null, false);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-bb', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionTableFile()
    {
        $form = new ExamStatementForm();
        if (Yii::$app->request->isAjax && Yii::$app->request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $fileName = $form->date . ".xlsx";
            $filePath = \Yii::getAlias('@modules') . '/exam/template/' . ($form->isProctor ? 'exam-proctor-statement.xlsx' : 'exam-statement.xlsx');
            $dataApp = $this->getApplications($form->date, $form->isProctor, $form->discipline);
            $this->openFile($filePath, $dataApp, $fileName);
        }
        return $this->renderAjax('export-data',['model' => $form]);
    }

    public function getApplications($date, $isProctor, $exam) {

        if(!$isProctor) {
            $models = $exam ? ExamStatement::find()->andWhere(['date' => $date, 'exam_id' => $exam])->andWhere(['is', 'proctor_user_id', null])->all() :
                ExamStatement::find()->joinWith('exam')->andWhere(['date' => $date])->andWhere(['is', 'proctor_user_id', null])
                    ->andWhere(['is', 'src_bb', null])->all();
        }else {
            $models = ExamStatement::find()->andWhere(['exam_id'=>$exam])->andWhere(['is not','proctor_user_id', null])->all();
        }

        $application = [];
        $i = 0;
        /* @var $entrant ExamStatement */
        foreach ($models as $key => $entrant) {
            $application[$key]['num'] = ++$i;
            $application[$key]['exam'] = $entrant->exam->discipline->name;
            $application[$key]['fio'] = $entrant->getEntrantFio();
            $application[$key]['proctor'] = $entrant->getProctorFio();
            $application[$key]['link'] = $entrant->src_bbb;
        }
        return $application;
    }


    public function openFile($filePath, $dataApp, $fileName) {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('application', $dataApp);
        $tbs->download($fileName);
    }

    /**
     * @return mixed
     */
    public function actionIndexAdmin()
    {
        $searchModel = new ExamStatementAdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-admin', [
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
            'examStatement' => $exam
        ]);
    }


    /**
     * @param integer $id
     * @param integer $status
     * @return mixed
     */
    public function actionStatus($id, $status)
    {
        try {
            $this->service->status($id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $eduLevel
     * @param $formCategory
     * @param $off
     * @return mixed
     */
    public function actionAllStatementCreate($eduLevel, $formCategory)
    {
        Yii::$app->queue->push(new StatementExamJob($this->service, ['eduLevel'=> $eduLevel, 'formCategory' => $formCategory]));
        $message = 'Задание отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionResetViolation($id)
    {
        try {
            $this->service->resetViolation($id);
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
    public function actionResetAttempt($id)
    {
        try {
            $this->service->resetAttempt($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $form = new ExamStatementMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionUpdateProctor($id)
    {
        $model = $this->findModel($id);
        $form = new ExamStatementProctorForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->updateProctor($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-proctor', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionReserveDate($id)
    {
        $model = $this->findModel($id);
        $form = new ExamDateReserveForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addReserveDate($model->id, $form, $this->jobEntrant);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('date', [
            'model' => $form,
        ]);
    }



    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSrc($id)
    {
        $model = $this->findModel($id);
        $form = new ExamSrcBBBForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addSrc($model->id, $form, $this->jobEntrant);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('src', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ExamStatement
    {
        if (($model = ExamStatement::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

}