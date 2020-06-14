<?php


namespace modules\entrant\controllers\backend;


use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\StatementRejection;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\models\UserAis;
use modules\entrant\services\UserAisService;
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
            if (UserAis::findOne(['user_id' => $model->user_id])) {
                Yii::$app->session->setFlash("error", "Вы не можете второй раз отправить! ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataIncoming($model->user_id));
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/import-entrant-with-doc?access-token=' . $token);
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
                if (array_key_exists('incoming_id', $result)) {
                    $this->aisService->create($model->user_id, $result, Yii::$app->user->identity->getId());
                    Yii::$app->session->setFlash('success', "Абитуриент успешно экпортирован в АИС ВУЗ");
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
     * @param integer $user
     * @param $statement
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatementIa($user, $statement)
    {
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
            Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        } else {
            $model = Profiles::find()
                ->alias('profiles')
                ->innerJoin(StatementIndividualAchievements::tableName(), StatementIndividualAchievements::tableName() . '.user_id=profiles.user_id')
                ->andWhere(['>', StatementIndividualAchievements::tableName() . '.status', StatementHelper::STATUS_DRAFT])
                ->andWhere(['profiles.user_id' => $user])->one();
            if (!$model) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }
            $incoming = UserAis::findOne(['user_id' => $model->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нарушена последовательность загрузки данных.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataIncomingStatementIa($model->user_id, $statement));
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/import-individual-application?access-token=' . $token);
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

            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService->addData(StatementIndividualAchievements::class, $statement);
                        Yii::$app->session->setFlash('success', "Заявление принято.");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }

    }

    /**
     * @param integer $user
     * @param $statement
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatement($user, $statement)
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
            $incoming = UserAis::findOne(['user_id' => $model->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нарушена последовательность загрузки данных.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataIncomingStatement($model->user_id, $statement));
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/import-usu-spec-application-cse-vi?access-token=' . $token);
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
            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService->addData(Statement::class, $statement);
                        Yii::$app->session->setFlash('success', "Заявление принято.");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }

    }

    /**
     * @param $statementId
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatementRemove($statementId)
    {
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен.
            Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        } else {
            $model = StatementRejection::findOne($statementId);
            if (!$model) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }
            $incoming = UserAis::findOne(['user_id' => $model->statement->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нарушена последовательность загрузки данных.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(DataExportHelper::dataRemoveStatement($model->statement->user_id, $model->statement->id));
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/remove-zuk?access-token=' . $token);
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
            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService-> removeZuk($model->id);
                        Yii::$app->session->setFlash('success', "Отзыв заявления принято.");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }

    }

    /**
     * @param $statementId
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatementRemoveCg($statementId)
    {
        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен.
            Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(['form']);
        } else {
            $model = StatementRejectionCg::findOne($statementId);
            if (!$model) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }
            $incoming = UserAis::findOne(['user_id' => $model->statementCg->statement->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нарушена последовательность загрузки данных.");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $ch = curl_init();
            $data = Json::encode(['remove'=>['incoming_id'=>$incoming->incoming_id, 'competitive_group_id'=>$model->cg->ais_id]]);
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/remove-zuk?access-token=' . $token);
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
            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService-> removeZukCg($model->id);
                        Yii::$app->session->setFlash('success', "Отзыв заявления принято.");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }

    }

    /**
     * @param integer $user
     * @param integer $statement
     * @param integer $consent
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatementConsent($user, $statement, $consent)
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
                ->andWhere(['>', 'statement.status', StatementHelper::STATUS_WALT])
                ->andWhere(['statement.id' => $statement])
                ->andWhere(['profiles.user_id' => $user])->one();
            if (!$model) {
                Yii::$app->session->setFlash("error", "Возможно вы не загрузили заявление (ЗУК) в АИС! ");
                return $this->redirect(Yii::$app->request->referrer);
            }

            $incoming = UserAis::findOne(['user_id' => $model->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нет данных абитуриента в АИСе! ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $consent = StatementConsentCg::findOne($consent);
            if (!$consent) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }

            $ch = curl_init();
            $data = Json::encode(['incoming_id' => $incoming->incoming_id,
                'competitive_group_id' => $consent->statementCg->cg->ais_id]);
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/add-zos?access-token=' . $token);
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
            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService->addData(StatementConsentCg::class, $consent);
                        Yii::$app->session->setFlash('success', "Заявление о согласии принято!");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);

        }
    }


    /**
     * @param integer $user
     * @param integer $statement
     * @param integer $consent
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionExportStatementConsentRemove($user, $statement, $consent)
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
                ->andWhere(['>', 'statement.status', StatementHelper::STATUS_WALT])
                ->andWhere(['statement.id' => $statement])
                ->andWhere(['profiles.user_id' => $user])->one();
            if (!$model) {
                Yii::$app->session->setFlash("error", "Возможно вы не загрузили заявление (ЗУК) в АИС! ");
                return $this->redirect(Yii::$app->request->referrer);
            }

            $incoming = UserAis::findOne(['user_id' => $model->user_id]);
            if (!$incoming) {
                Yii::$app->session->setFlash("error", "Нет данных абитуриента в АИСе! ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $consent = StatementRejectionCgConsent::findOne($consent);
            if (!$consent) {
                throw new NotFoundHttpException('Такой страницы не существует.');
            }

            $ch = curl_init();
            $data = Json::encode(['incoming_id' => $incoming->incoming_id,
                'competitive_group_id' => $consent->statementConsentCg->statementCg->cg->ais_id]);
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'].'/remove-zos?access-token=' . $token);
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
            if (array_key_exists('status_id', $result)) {
                if ($result['status_id'] == StatementHelper::STATUS_ACCEPTED) {
                    try {
                        $this->aisService->removeZos($consent->id);
                        Yii::$app->session->setFlash('success', "Заявление об отзыве согласии принято!");
                    } catch (\DomainException $e) {
                        Yii::$app->errorHandler->logException($e);
                        Yii::$app->session->setFlash('error', $e->getMessage());
                    }
                }
            }
            if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }
    }
    public function actionForm()
    {
        $user = Yii::$app->request->post('username');
        $pass = Yii::$app->request->post('password');
        if ($user && $pass) {
            $client = new Client(['baseUrl' => Yii::$app->params['ais_server'], 'transport' => 'yii\httpclient\CurlTransport']);
            $response = $client->createRequest()
                ->setMethod('get')
                ->setUrl('get-access-token')
                ->addHeaders(['Authorization' => 'Basic ' . base64_encode("$user:$pass")])
                ->setOptions([
              //      'proxy' => 'proxy.server:8000',
                    'timeout' => 30,
                ])->send();
            if (!$response->isOk) {
                Yii::$app->session->setFlash("error", "Ошибка! ".$response->statusCode);
                return $this->redirect(Yii::$app->request->referrer);
            }
            $result = $response->data;
            try {
                if (key_exists('token', $result)) {
                    $this->service->addToken(\Yii::$app->user->identity->getId(), $result['token']);
                    Yii::$app->session->setFlash('success', "Токен успешно создан и сохранен!");
                    return $this->redirect(['default/index']);
                } else if (key_exists('message', $result)) {
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