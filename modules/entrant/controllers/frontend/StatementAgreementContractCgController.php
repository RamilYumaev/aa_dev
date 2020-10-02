<?php


namespace modules\entrant\controllers\frontend;
use common\auth\forms\ResetPasswordForm;
use dictionary\helpers\DictFacultyHelper;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\forms\ReceiptContractForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\DataExportHelper;
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
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StatementAgreementContractCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementAgreementContractCgService $service, $config = [])
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
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        $cg = $this->findConsentCg($id);
        if (!SettingContract::isJob($cg->cg)) {
                Yii::$app->session->setFlash("error", "Уже нельзя заключать договоры");
                return $this->redirect(Yii::$app->request->referrer);
        }
        if (($incoming = UserAis::findOne(['user_id' => $this->getUser()])) == null) {
            Yii::$app->session->setFlash("error", "Сбой системы. Попробуте в другой раз");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $count = StatementAgreementContractCg::find()->statementUser($this->getUser())->count();
        if ($count > 3) {
            Yii::$app->session->setFlash("error", "Вы не можете создать больше 3-х договоров ");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $ch = curl_init();
        $data = Json::encode([
            'token'=> "849968aa53dd0732df8c55939f6d1db9",
            "competitive_group_id"=>$cg->cg->ais_id,
            "incoming_id"=>$incoming->incoming_id,]);
        curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_agreement'].'/check-ball?access-token=' . $this->token());
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        if ($status_code !== 200) {
            Yii::$app->session->setFlash("error", "Ошибка! $result");
            return $this->redirect(Yii::$app->request->referrer);
        }
        curl_close($ch);

        $result = Json::decode($result);
        try {
            if (array_key_exists('status', $result)) {
                if($result['status']== true) {
                    $this->service->create($id, $this->getUser());
                    Yii::$app->session->setFlash('success', "Договор успешно создан");
                } else {
                    Yii::$app->session->setFlash('danger', "Ваши баллы по предметам не соответствуют 
                    условиям заключения договора");
                }
            } else if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }
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
        $anketa = $this->getAnketa();

        if(!$agreement->statementCg->cg->education_year_cost) {
            Yii::$app->session->setFlash('warning', "Нет стоимости в настройках системы. Обратитесь к администратору");
           return $this->redirect(Yii::$app->request->referrer);

        }   if($agreement->number) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

            $content = $this->renderPartial('pdf/_main', ["agreement" => $agreement, "anketa"=> $anketa]);
            $pdf = PdfHelper::generate($content, FileCgHelper::fileNameAgreement(".pdf"));
            $render = $pdf->render();

            try {
                $this->service->addCountPages($id, count($pdf->getApi()->pages));
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $render;
        }else {
            Yii::$app->session->setFlash('warning', "Отсутствует номер договора!");
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
 *
 * @param $id
 * @return mixed
 * @throws NotFoundHttpException
 * @throws \yii\base\InvalidConfigException
 */

    public function actionPdfReceipt($id)
    {
        $receipt= $this->findModelReceipt($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf/_main_receipt', ["receipt" => $receipt,]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameReceipt(".pdf"));
        $render = $pdf->render();

        try {
            $this->service->addCountPagesReceipt($id, count($pdf->getApi()->pages));
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
                $this->service->dataReceipt($id, $form);
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
     * @throws \yii\base\InvalidConfigException
     */

    public function actionDeleteReceipt($id)
    {
        $this->findModelReceipt($id);
        try {
            $this->service->deleteReceipt($id);
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

    public function actionCreatePdf($id)
    {
        $agreement= $this->findModel($id);
        if (!SettingContract::isJob($agreement->statementCg->cg)) {
            Yii::$app->session->setFlash("error", "Уже нельзя сформировать договор");
            return $this->redirect(Yii::$app->request->referrer);
        }
        if($agreement->typeEntrant() || $agreement->typePersonal() || $agreement->typeLegal()) {
            $this->exportData($agreement);
        }else {
            Yii::$app->session->setFlash('warning', "Вы не выбрали заказчика или отсуствуют его данные");

        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function token() {
        return '849968aa53dd0732df8c55939f6d1db9';
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
             $model = PersonalEntity::findOne($agreement->record_id) ?? null;
             $form = new PersonalEntityForm($this->getUser(), $model);
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                     $this->service->createOrUpdatePersonal($form, $agreement->id);
                     if($agreement->statusNoAccepted()){
                         $this->exportData($agreement, "Договор успешно обновлен!");
                     }
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
             $model = LegalEntity::findOne($agreement->record_id) ?? null;
             $form = new LegalEntityForm($this->getUser(), $model);
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                     $this->service->createOrUpdateLegal($form, $agreement->id);
                     if($agreement->statusNoAccepted()){
                         $this->exportData($agreement, "Договор успешно обновлен!");
                     }
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
    protected function findModel($id): StatementAgreementContractCg
    {
        if (($model = StatementAgreementContractCg::find()->statementOne($id, $this->getUser())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelReceipt($id): ReceiptContract
    {
        if (($model = ReceiptContract::find()->receiptOne($id, $this->getUser())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id, $this->getUser());
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

    protected function findConsentCg($id) {
        if (!$model = StatementCg::find()->alias('consent-cg')->joinWith('statement')
            ->where(['consent-cg.id' => $id, 'user_id' => $this->getUser()])->one()) {
            throw new \DomainException('Образовательная программа не найдена.');
        }
        return $model;
    }



    private function  getUser() {
       return Yii::$app->user->identity->getId();
    }

    private function getAnketa()
    {
        if(!$anketa = \Yii::$app->user->identity->anketa())
        {
            return $this->redirect('default/index');
        }
        return $anketa;
    }


    protected function exportData(StatementAgreementContractCg $agreement, $message = "Договор успешно сформирован")
    {
        if (($incoming = UserAis::findOne(['user_id' => $this->getUser()])) == null) {
            Yii::$app->session->setFlash("error", "Сбой системы. Попробуте в другой раз");
            return $this->redirect(Yii::$app->request->referrer);
        }
        $ch = curl_init();
        $data = Json::encode(DataExportHelper::dataIncomingContract($agreement, $incoming));
        curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_agreement'].'/agreement-contract?access-token=' . $this->token());
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
        if ($status_code !== 200) {
            Yii::$app->session->setFlash("error", "Ошибка! $result");
            return $this->redirect(Yii::$app->request->referrer);
        }
        curl_close($ch);
        $result = Json::decode($result);
        try {
            if (array_key_exists('number', $result)) {
                $this->service->addNumber($agreement->id, $result['number']);
                Yii::$app->session->setFlash('success', $message);
            } else if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }


}