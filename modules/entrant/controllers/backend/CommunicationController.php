<?php


namespace modules\entrant\controllers\backend;


use olympic\services\auth\UserService;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;

class CommunicationController extends Controller
{
    private $service;


    public function __construct($id, $module,  UserService $service, $config = [])
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
                    'export-date' => ['POST']
                ],
            ],
        ];
    }


    public function actionExportData() {
        if (!\Yii::$app->user->identity->getAisToken()) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
            Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        }
    }


    public function actionForm() {
        $user = Yii::$app->request->post('username');
        $pass = Yii::$app->request->post('password');
        if($user && $pass) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'http://85.30.248.93:7779/incoming_2020/fok/sdo/get-access-token');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_USERPWD, "$user:$pass");
            $result=curl_exec ($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            if ($status_code !== 200) {
                Yii::$app->session->setFlash("error", "Ошибка! Неверный логин или пароль");
                return $this->redirect(Yii::$app->request->referrer);
            }
            curl_close ($ch);
            try {
                $result = Json::decode($result);
                if(key_exists('token', $result)) {
                    $this->service->addToken(\Yii::$app->user->identity->getId(), $result['token']);
                    Yii::$app->session->setFlash('success', "Успешно обновлен");
                    return $this->redirect(['default/index']);
                } else if(key_exists('message',$result)) {
                    Yii::$app->session->setFlash('warning', $result['message']);
                    return $this->redirect(Yii::$app->request->referrer);
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('form');
    }




}