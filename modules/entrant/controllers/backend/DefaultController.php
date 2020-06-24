<?php

namespace modules\entrant\controllers\backend;

use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\searches\ProfilesStatementSearch;
use modules\entrant\services\EmailDeliverService;
use olympic\models\auth\Profiles;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    private $service;
    public function __construct($id, $module, EmailDeliverService $service, $config = [])
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
                    'send-error' => ['POST'],
                ],
            ],
        ];
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSendError($user)
    {
        $this->findModel($user);
        $emailId = $this->jobEntrant->email_id;
        if (!$emailId) {
            Yii::$app->session->setFlash("error", "У вас отсутствует электронная почта для рассылки. 
                Обратитесть к администратору");
            return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $this->service->errorSend($emailId, $user);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $id
     * @param  $is_id
     * @return mixed
     */
    public function actionIndex($type = null, $is_id = false)
    {
        $searchModel = new ProfilesStatementSearch($this->jobEntrant, $type, $is_id);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);
    }
    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFull($user)
    {
        $profile = $this->findModel($user);
        return $this->render('full', [
            'profile' => $profile
        ]);
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFiles($user)
    {
        $profile = $this->findModel($user);
        return $this->render('files', [
            'profile' => $profile
        ]);
    }

    public function actionExcel()
    {
        \moonland\phpexcel\Excel::widget([
            'asAttachment'=>true,
            'fileName' => date('d-m-Y H-i-s').' file',
            'models' => (new ProfileStatementReadRepository($this->jobEntrant))->readData(AisReturnDataHelper::AIS_NO)->all(),
            'mode' => 'export', //default value as 'export'
            'columns' => ['user_id'], //without header working, because the header will be get label from attribute label.
            'headers' => ['user_id'=> "Юзер ID"],
        ]);
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDataJson($user) {
        $profile = $this->findModel($user);
        $result = DataExportHelper::dataIncoming($profile->user_id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Profiles
    {
        $query = (new ProfileStatementReadRepository($this->jobEntrant))->readData(null)
            ->andWhere(['profiles.user_id' => $id]);

        if (($model = $query->one()) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}
