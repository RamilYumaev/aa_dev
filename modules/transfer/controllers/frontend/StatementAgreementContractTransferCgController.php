<?php


namespace modules\transfer\controllers\frontend;
use common\auth\forms\ResetPasswordForm;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\models\SettingEntrant;
use modules\entrant\forms\ContractMessageForm;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\SettingContract;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\UserAis;
use modules\entrant\services\StatementAgreementContractCgService;
use \kartik\mpdf\Pdf;
use modules\transfer\helpers\ContractHelper;
use modules\transfer\models\LegalEntityTransfer;
use modules\transfer\models\PassExam;
use modules\transfer\models\PersonalEntityTransfer;
use modules\transfer\models\ReceiptContractTransfer;
use modules\transfer\models\StatementAgreementContractTransferCg;
use modules\transfer\models\StatementTransfer;
use modules\transfer\services\StatementAgreementContractTransferCgService;
use Mpdf\Tag\P;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StatementAgreementContractTransferCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementAgreementContractTransferCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

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

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
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
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */


    public function actionCreate($id)
    {
        $model = $this->findModelStatementTransfer($id);
        try {
            $this->service->create($model);
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

    public function actionUpdateReceipt($id)
    {
        $receipt= $this->findModelReceipt($id);
        $form = new ReceiptContractForm($receipt);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $receipt->bank = $form->bank;
                $receipt->pay_sum = $form->pay_sum;
                $receipt->date = DateFormatHelper::formatRecord($form->date);
                $receipt->save();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax("update-receipt", ["model" => $form]);
    }




    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionForm($id)
    {
        $agreement= $this->findModel($id);
        if($agreement->number && !$agreement->statusNoAccepted()) {
            Yii::$app->session->setFlash('warning', "Редактировать нельзя, так как Вы сформировали договор");
            return $this->redirect(['post-document/agreement-contract']);
        } else {
         if($agreement->type == 1) {
             return $this->redirect(Yii::$app->request->referrer);
         }elseif($agreement->type == 2) {
             $model = PersonalEntityTransfer::findOne($agreement->record_id) ??  new PersonalEntityTransfer(['user_id'=> $this->getUser()]);
             $form = $model;
             $form->date_of_issue= $form->date_of_issue ? $model->getValue("date_of_issue") : "";
             $form->user_id = $this->getUser();
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                   ///  $form->date_of_issue=DateFormatHelper::formatRecord($form->date_of_issue);
                     $form->save(false);
                     $agreement->record_id= $form->id;
                     $agreement->save(false);
                     return $this->redirect(['post-document/agreement-contract']);
                 } catch (\DomainException $e) {
                     Yii::$app->errorHandler->logException($e);
                     Yii::$app->session->setFlash('error', $e->getMessage());
                 }
             }
             return $this->render('_form_personal', [
                 'model' => $form,
             ]);
         }elseif($agreement->type == 3) {
             $model = LegalEntityTransfer::findOne($agreement->record_id) ?? new LegalEntityTransfer();
             $form = $model;
             $form->user_id =$this->getUser();
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                     $form->save();
                     $agreement->record_id= $form->id;
                     $agreement->save(false);
                     return $this->redirect(['post-document/agreement-contract']);
                 } catch (\DomainException $e) {
                     Yii::$app->errorHandler->logException($e);
                     Yii::$app->session->setFlash('error', $e->getMessage());
                 }
             }
             return $this->render('_form_legal', [
                 'model' => $form,
             ]);
         }
        }
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
     * @return array|string|Response
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
        $form->message = '';
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model->message_st = $form->message;
                $model->status_id = ContractHelper::STATUS_FIX;
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
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionAddReceipt($id)
    {
        $agreement = $this->findModel($id);
        $period = Yii::$app->request->post('period');
        if ($period) {
            try {
                $this->service->addReceipt($period, $agreement->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('add-receipt',['agreement' => $agreement]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionDelete($id)
    {
        $agreement = $this->findModel($id);
            try {
                $this->service->delete($agreement->id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDataJson($id) {
        $agreement = $this->findModel($id);
        if (($incoming = UserAis::findOne(['user_id' => $this->getUser()])) == null) {
            Yii::$app->session->setFlash("error", "Сбой системы. Попробуте в другой раз");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $result = DataExportHelper::dataIncomingContract($agreement, $incoming);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementAgreementContractTransferCg
    {
        if (($model = StatementAgreementContractTransferCg::
            find()->alias('sactcg')->joinWith("statementTransfer.passExam")
                ->andWhere(['sactcg.id' => $id])
                ->andWhere(['finance'=> DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT])
                ->andWhere(['user_id'=> $this->getUser(),
                'success_exam'=> PassExam::SUCCESS])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelReceipt($id): ReceiptContractTransfer
    {
        if (($model = ReceiptContractTransfer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        $customer = Yii::$app->request->post('customer');
        $idLegal= Yii::$app->request->post('id-legal');
        $idPersonal = Yii::$app->request->post('id-personal');
        $agreement = $this->findModel($id);
        if($agreement->number) {
            Yii::$app->session->setFlash('warning', "Редактировать нельзя, так как Вы сформировали договор");
            return $this->redirect(['post-document/agreement-contract']);
        }
        if ($customer) {
            if($customer == 2) {
               $rec =  $idPersonal;
            }elseif($customer == 3) {
                $rec =  $idLegal;
            } else {
                $rec =0;
            }
            try {
                $statement = $this->service->add($agreement->id, $customer, $rec);
                if($rec) {
                    return $this->redirect(Yii::$app->request->referrer);
                }
                return $this->redirect(['form', 'id' => $statement->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());

                return $this->redirect(Yii::$app->request->referrer);
            }

        }
        return $this->renderAjax('add',['agreement' => $agreement]);
    }

    /**
     * @param $id
     * @return array|\yii\db\ActiveRecord|null
     * @throws NotFoundHttpException
     */

    protected function findModelStatementTransfer($id) {
        if (!$model = StatementTransfer::find()->joinWith('passExam')->andWhere(['statement_transfer.id'=>$id,
            'user_id'=> $this->getUser(),
            'success_exam'=> PassExam::SUCCESS])->one()) {
            throw new NotFoundHttpException();
        }
        return $model;
    }

    private function  getUser() {
       return Yii::$app->user->identity->getId();
    }
}