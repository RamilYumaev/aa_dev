<?php


namespace modules\entrant\controllers\backend;


use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\UserAis;
use modules\entrant\services\UserAisService;
use olympic\models\auth\Profiles;
use olympic\services\auth\UserService;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommunicationController extends Controller
{
    private $service;
    private $aisService;


    public function __construct($id, $module, UserService $service, UserAisService $aisService, $config = [])
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
                    'export-statement' => ['POST']
                ],
            ],
        ];
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportData($user)
    {
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
                Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        } else {
            $model = Profiles::find()
                ->alias('profiles')
                ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                ->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT])
                ->andWhere(['profiles.user_id' => $user])->one();
            if (!$model) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }
            if (UserAis::findOne(['user_id'=> $model->user_id])) {
                Yii::$app->session->setFlash("error", "Вы не можете второй раз отправить! ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataIncoming($model->user_id));
            curl_setopt($ch, CURLOPT_URL, 'http://85.30.248.93:7779/incoming_2020/fok/sdo/import-entrant-with-doc?access-token='.$token);
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
            try {
                $result = Json::decode($result);
                if(key_exists('incoming_id', $result)) {
                    $this->aisService->create(5, $result, Yii::$app->user->identity->getId());
                    Yii::$app->session->setFlash('success', "Успешно обновлен");
                } else if(key_exists('message',$result)) {
                    Yii::$app->session->setFlash('warning', $result['message']);
                }
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            Yii::$app->session->setFlash('warning', $result);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatement($user)
    {
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
            Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        } else {
            $model = Profiles::find()
                ->alias('profiles')
                ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                ->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT])
                ->andWhere(['profiles.user_id' => $user])->one();
            if (!$model) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }
            if (!UserAis::findOne(['user_id'=> $model->user_id])) {
                Yii::$app->session->setFlash("error", "Нет данных абитуриента в АИСе! ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataIncomingStatement($model->user_id));
            curl_setopt($ch, CURLOPT_URL, 'http://85.30.248.93:7779/incoming_2020/fok/sdo/import-usu-spec-application-cse-vi?access-token='.$token);
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
            Yii::$app->session->setFlash('success', $result);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    public function actionForm() {
        $user = Yii::$app->request->post('username');
        $pass = Yii::$app->request->post('password');
        if($user && $pass) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,'http://85.30.248.93:7779/incoming_2020/fok/sdo/get-access-token');
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            curl_setopt($ch, CURLOPT_POST, true);
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