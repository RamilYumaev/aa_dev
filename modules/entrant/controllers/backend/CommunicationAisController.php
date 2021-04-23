<?php


namespace modules\entrant\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\ContractHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\jobs\api\CseJob;
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
use modules\entrant\services\UserDisciplineService;
use olympic\models\auth\Profiles;
use olympic\services\auth\UserService;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\httpclient\Client;
use api\client\Client as AisClient;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommunicationAisController extends Controller
{
    private $service;

    public function __construct($id, $module, UserDisciplineService $service,  $config = [])
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
                    'data-export' => ['POST'],
                    'export-statement' => ['POST'],
                    'export-statement-ia'=> ['POST']
                ],
            ],
        ];
    }


    public function actionDataExport()
    {
        $token = $this->getToken();
        $url = 'get-cse-result?access-token=' . $token;
        if($data  = DataExportHelper::cseIncomingId()) {
            Yii::$app->queue->push(new CseJob($this->service, [
                'data'=> $data, 'url' => $url
            ]));
            $message = 'Задание отправлено в очередь';
        } else {
            $message = 'Не найдены новые непроверенные статусы ЕГЭ/ВИ';
        }
        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    protected function getToken() {
        if (!$token = Yii::$app->user->identity->getAisToken()) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
                Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['communication/form']);
        }
        return $token;
    }
    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}