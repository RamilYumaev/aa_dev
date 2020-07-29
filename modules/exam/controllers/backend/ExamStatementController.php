<?php


namespace modules\exam\controllers\backend;


use kartik\date\DatePicker;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\exam\forms\ExamDateReserveForm;
use modules\exam\forms\ExamForm;
use modules\exam\forms\ExamSrcBBBForm;
use modules\exam\forms\ExamStatementMessageForm;
use modules\exam\models\Exam;
use modules\exam\models\ExamStatement;
use modules\exam\searches\ExamSearch;
use modules\exam\searches\ExamStatementSearch;
use modules\exam\services\ExamStatementService;
use yii\base\ExitException;
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

    public function beforeAction($event)
    {
        if(!in_array($this->jobEntrant->category_id, JobEntrantHelper::isProctor())) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
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
    public function actionMyList()
    {
        $searchModel = new ExamStatementSearch($this->jobEntrant);
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
        $searchModel = new ExamStatementSearch($this->jobEntrant);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-bb', [
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
    public function actionAllStatementCreate($eduLevel, $formCategory, $off)
    {
        try {
            $this->service->addAllStatement($eduLevel, $formCategory, $off);
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