<?php

namespace modules\transfer\controllers\backend;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\readRepositories\ProfileStatementReadRepository;
use modules\entrant\searches\ProfilesFileSearch;
use modules\entrant\searches\ProfilesStatementCOZFOKSearch;
use modules\entrant\searches\ProfilesStatementSearch;
use modules\entrant\services\EmailDeliverService;
use modules\transfer\models\TransferMpgu;
use modules\transfer\search\TransferSearch;
use olympic\models\auth\Profiles;
use Yii;
use yii\base\ExitException;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProfilesController extends Controller
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

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSendError($user)
    {
         $model =  $this->findModel($user);
        $emailId = $this->jobEntrant->email_id;
        if (!$emailId) {
            Yii::$app->session->setFlash("error", "У вас отсутствует электронная почта для рассылки. 
                Обратитесть к администратору");
            return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $this->service->errorSend($emailId, $model->user_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }


    /**
     * @param null $type
     * @param  $is_id
     * @return mixed
     */
    public function actionIndex($type = null)
    {
        $searchModel = new TransferSearch($type);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'type' => $type
        ]);
    }

    /**
     * @param null $status
     * @return mixed
     */
    public function actionIndexFile()
    {
        $searchModel = new ProfilesFileSearch($this->jobEntrant);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-file', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
    }


    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $transfer = $this->findModel($id);
        return $this->render('view', [
            'transfer' => $transfer
        ]);
    }

    /**
     * @param integer $user
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionFiles($id)
    {
        $transfer = $this->findModel($id);
        return $this->render('files', [
            'transfer' => $transfer,
            'profile' => $transfer->profile
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): ?TransferMpgu
    {

        if (($model = TransferMpgu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}