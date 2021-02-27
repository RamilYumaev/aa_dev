<?php


namespace modules\entrant\controllers\backend;


use common\helpers\EduYearHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\FilePdfForm;
use modules\entrant\forms\ReceiptContractMessageForm;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\ReceiptContractSearch;
use modules\entrant\searches\StatementAgreementContractSearch;
use modules\entrant\searches\StatementConsentSearch;
use modules\entrant\services\AgreementService;
use modules\entrant\services\StatementAgreementContractCgService;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReceiptContractController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementAgreementContractCgService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function beforeAction($event)
    {
        if($this->getJobEntrant()->isStatusDraft() || !in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesAgreement())) {
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
     * @param null $status
     * @return mixed
     */
    public function actionIndex($status = null)
    {
        $searchModel = new ReceiptContractSearch($status, $this->jobEntrant);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'status'=> $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $contract = $this->findModel($id);
        return $this->render('view', ['receipt' => $contract]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $form = new ReceiptContractMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessageReceipt($model, $form);
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

    public function actionGet($id)
    {
        $model = $this->findModel($id);
        $filePath = $model->getUploadedFilePath('pdf_file');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        return Yii::$app->response->sendFile($filePath);
    }


    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFilePdf($id)
    {
        $model = $this->findModel($id);
        $form = new FilePdfForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addFile($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('file', [
            'model' => $form,
        ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatus($id, $status)
    {
        $receipt = $this->findModel($id);
        try {
            $this->service->statusReceipt($receipt, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionIsMonth($id, $status)
    {
        $contract = $this->findModel($id);
        try {
            $this->service->month($contract->id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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
        $agreement= $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement-agreement-contract-cg/pdf/_main', ["agreement" => $agreement,
            "anketa"=> $agreement->statementCg->statement->profileUser->anketa]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameAgreement(".pdf"));
        $render = $pdf->render();
        return $render;
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ReceiptContract
    {

        if (($model = ReceiptContract::findOne($id))  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
