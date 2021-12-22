<?php


namespace modules\transfer\controllers\backend;


use common\helpers\EduYearHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\ContractMessageForm;
use modules\entrant\services\UserAisService;
use modules\transfer\forms\FilePdfForm;
use modules\transfer\helpers\ContractHelper;
use modules\transfer\models\ReceiptContractTransfer;
use modules\transfer\search\StatementAgreementContractSearch;
use modules\transfer\models\StatementAgreementContractTransferCg;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AgreementContractController extends Controller
{
    private $service;
    private $userAisService;

    public function __construct($id, $module, StatementAgreementContractTransferCg $service,  UserAisService $userAisService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->userAisService = $userAisService;
    }

    public function beforeAction($event)
    {
        if( $this->getJobEntrant()->isStatusDraft() || !in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesAgreement())) {
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
     * @param null $faculty
     * @param null $eduLevel
     * @return mixed
     */
    public function actionIndex($status = null, $faculty = null, $eduLevel = null)
    {
        $searchModel = new StatementAgreementContractSearch($status, null, $faculty, $eduLevel);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        return $this->render('view', ['contract' => $contract]);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $form = new ContractMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model->message = $form->message;
                $model->status_id = ContractHelper::STATUS_NO_ACCEPTED;
                $model->save();
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
     * @return \yii\console\Response|Response
     * @throws NotFoundHttpException
     */

    public function actionGetReceipt($id)
    {
        $model = $this->findModel($id);
        $filePath = $model->receiptContract->getUploadedFilePath('file_pdf');
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
        $form->setScenario($form::NUMBER);
        $form->text = $model->number;

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model->setFilePdf($form->file_name);
                $model->status_id = ContractHelper::STATUS_CREATED;
                $model->number = $form->text;
                $this->send($model);
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

    /**
     * @param $id
     * @return array|string|Response
     * @throws NotFoundHttpException
     */

    public function actionFilePdfReceipt($id)
    {
        $model = $this->findModel($id);
        $form = new FilePdfForm($model);

        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $receipt = $model->receiptContract ?? new ReceiptContractTransfer();
                $receipt->contract_cg_id = $model->id;
                $receipt->setFilePdf($form->file_name);
                $receipt->status_id = ContractHelper::STATUS_NEW;
                $receipt->save(false);
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
        $contract = $this->findModel($id);
        try {
            $contract->status_id = $status;
            if($contract->statusAccepted() && !$contract->receiptContract) {
                throw new \DomainException("Необходимо загрузить квитанцию");
            }
            $this->send($contract);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function send(StatementAgreementContractTransferCg $transferCg) {
        $emailId = $this->jobEntrant->email_id;
        if (!$emailId) {
            Yii::$app->session->setFlash("error", "У вас отсутствует электронная почта для рассылки. 
                Обратитесть к администратору");
            return $this->redirect(Yii::$app->request->referrer);
        }
        if($transferCg->statusSuccess()) {
            $this->userAisService->contractSend($emailId,
                $transferCg->statementTransfer->user_id, $transferCg->successTextEmail);
        }
        else{
            $this->userAisService->contractSend($emailId,
                $transferCg->statementTransfer->user_id, $transferCg->textEmail);
        }
        $transferCg->save(false);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementAgreementContractTransferCg
    {
        if (($model = StatementAgreementContractTransferCg::findOne($id))  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
