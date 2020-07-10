<?php


namespace modules\entrant\controllers\backend;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\forms\StatementRejectionCgMessageForm;
use modules\entrant\forms\StatementRejectionConsentMessageForm;
use modules\entrant\forms\StatementRejectionMessageForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\searches\StatementConsentRejectionSearch;
use modules\entrant\searches\StatementRejectionCgSearch;
use modules\entrant\searches\StatementRejectionSearch;
use modules\entrant\searches\StatementSearch;
use modules\entrant\services\StatementService;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class StatementRejectionController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex($status = null)
    {
        $searchModel = new StatementRejectionSearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }

    public function actionConsentIndex($status = null)
    {
        $searchModel = new StatementConsentRejectionSearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consent/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }

    public function actionCgIndex($status = null)
    {
        $searchModel = new StatementRejectionCgSearch($this->jobEntrant, $status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }

    public function actionCgNew()
    {
        $searchModel = new StatementRejectionCgSearch($this->jobEntrant, StatementHelper::STATUS_WALT);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);

        return $this->render('new', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusView($id)
    {
        $this->findModelRejection($id);
        try {
            $this->service->statusRejectionView($id);
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

    public function actionStatusViewConsent($id)
    {
        $this->findModelConsent($id);
        try {
            $this->service->statusRejectionConsentView($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }



    /**
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatus($id, $status)
    {
        $this->findModelRejection($id);
        try {
            $this->service->statusRejection($id, $status);
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
        $model = $this->findModelRejection($id);
        $form = new StatementRejectionMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessageRejection($model->id, $form);
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
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusConsent($id, $status)
    {
        $this->findModelConsent($id);
        try {
            $this->service->statusConsent($id, $status);
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

    public function actionMessageConsent($id)
    {
        $model = $this->findModelConsent($id);
        $form = new StatementRejectionConsentMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessageConsent($model->id, $form);
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
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusCg($id, $status)
    {
        $this->findModelCg($id);
        try {
            $this->service->statusCg($id, $status);
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

    public function actionMessageCg($id)
    {
        $model = $this->findModelCg($id);
        $form = new StatementRejectionCgMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessageCg($model->id, $form);
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


    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    public function actionNew()
    {
        $searchModel = new StatementRejectionSearch($this->jobEntrant, StatementHelper::STATUS_WALT);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);

        return $this->render('new', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionConsentNew()
    {
        $searchModel = new StatementConsentRejectionSearch($this->jobEntrant, StatementHelper::STATUS_WALT);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, 5);

        return $this->render('consent/new', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statementRejection = $this->findModelRejection($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main', ["statementRejection" => $statementRejection,]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesRejection($statementRejection->id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }


        return $render;

    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfCg($id)
    {
        $statementRejection = $this->findModelCg($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main_cg', ["statementRejection" => $statementRejection]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesCg($statementRejection->id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;
    }



    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfConsent($id)
    {
        $statementConsent = $this->findModelConsent($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');
        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-rejection/pdf/_main_consent', ["statementConsent" => $statementConsent]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameRejection('.pdf'));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesConsent($statementConsent->id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;
    }




    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelRejection($id): StatementRejection
    {
        if (($model = StatementRejection::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelCg($id): StatementRejectionCg
    {
        if (($model = StatementRejectionCg::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelConsent($id): StatementRejectionCgConsent
    {
        if (($model = StatementRejectionCgConsent::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

}