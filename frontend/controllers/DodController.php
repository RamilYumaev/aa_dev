<?php


namespace frontend\controllers;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingDeliveryStatusService;
use dod\forms\SignupDodForm;
use dod\helpers\DateDodHelper;
use dod\readRepositories\DateDodReadRepository;
use dod\services\DodRegisterUserService;
use frontend\components\UserNoEmail;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use Yii;

class DodController extends Controller
{
    private $repository;
    private $service;
    private $deliveryStatusService;

    public function __construct($id, $module, DodRegisterUserService $service,
                                DateDodReadRepository $repository, SendingDeliveryStatusService $deliveryStatusService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
        $this->deliveryStatusService  = $deliveryStatusService;
    }


    public function beforeAction($action)
    {
        return (new UserNoEmail())->redirect();
    }


    /**
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /*
    * @param $id
    * @return mixed
    * @throws NotFoundHttpException
    */
    public function actionRegistrationOnDod($id)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }
        $dod = $this->findDod($id);
        $form = new SignupDodForm($dod);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signup($form);
                Yii::$app->session->setFlash('success', 'Спасибо за регистрацию. 
                Вам отправлено письмо. Для активации учетной записи, пожалуйста, следуйте инструкциям в письме.');
                $this->redirect('index');
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->render('registration-on-dod', [
            'dod' => $dod,
            'model' => $form
        ]);
    }

    /*
   * @param $id
   * @param $hash
   * @return mixed
   * @throws NotFoundHttpException
   */
    public function actionDod($id, $hash =null)
    {
        if ($hash !== null) {
            $modelSendingDelivery =  SendingDeliveryStatus::find()
                ->hash($hash)
                ->type(SendingDeliveryStatusHelper::TYPE_DOD)
                ->typeSending(SendingDeliveryStatusHelper::TYPE_SEND_DOD_WEB)
                ->one();
            if (!$modelSendingDelivery) {
                throw new HttpException('404', 'Такой страницы не существует');
            }
            if (!$modelSendingDelivery->isStatusRead()) {
                try {
                    $this->deliveryStatusService->statusRead($modelSendingDelivery->id);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        $dod = $this->findDod($id);
        return $this->render('dod', [
            'dod' => $dod
        ]);
    }

    /*
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findDod($id)
    {
        $model = $this->repository->find($id);
        if (!$model || $model->isTypeIntramural()  || !DateDodHelper::maxDate($model->date_time, $model->type, $model->dod_id)) {
            throw new HttpException('404', 'Такой страницы не существует');
         }

        return $model;
    }
}