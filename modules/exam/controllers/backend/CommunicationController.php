<?php


namespace modules\exam\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\UserAis;
use modules\entrant\services\UserAisService;
use modules\exam\helpers\ExamDataExportHelper;
use modules\exam\models\Exam;
use olympic\models\auth\Profiles;
use olympic\services\auth\UserService;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\httpclient\Client;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommunicationController extends Controller
{
    private $service;
    private $aisService;


    public function __construct($id, $module,
                                UserService $service,
                                UserAisService $aisService,
                                $config = [])
    {
        $this->service = $service;
        $this->aisService = $aisService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'export-data' => ['POST'],
                    'export-statement' => ['POST'],
                    'export-statement-ia'=> ['POST']
                ],
            ],
        ];
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    /**
     * @param $examId
     * @param $type
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportData($examId, $type)
    {
        $exam = $this->findModel($examId);
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
                Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['data-entrant/communication/form']);
        } else {
            $ch = curl_init();
            $data = Json::encode(ExamDataExportHelper::dataExportExamAll($examId, $type));
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/incoming-exam/?access-token=' . $token);
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
                    Yii::$app->session->setFlash('success', "Ведомость успешно экпортирована в АИС ВУЗ");
                } else if (array_key_exists('message', $result)) {
                    Yii::$app->session->setFlash('warning', $result['message']);
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            //  Yii::$app->session->setFlash('warning', Json::decode($result));
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     * @param $examId
     * @param $type
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionJsonData($examId, $type) {
        $exam = $this->findModel($examId);
        $result =  Json::encode(ExamDataExportHelper::dataExportExamAll($examId, $type));
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Exam
    {
        if (($model = Exam::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }






}