<?php
namespace frontend\controllers;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingDeliveryStatusService;
use olympic\readRepositories\OlimpicReadRepository;
use yii\web\Controller;
use yii\web\HttpException;


class InvitationController extends Controller
{
    public  $layout = 'print';
    private $repository;
    private $service;

    public function __construct($id, $module, OlimpicReadRepository $repository, SendingDeliveryStatusService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    public function actionIndex($hash)
    {
        $this->layout = '@app/views/layouts/print.php';
        $model =  SendingDeliveryStatus::find()
            ->hash($hash)
            ->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
            ->typeSending(SendingDeliveryStatusHelper::TYPE_SEND_INVITATION)
            ->one();
        if (!$model) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        $olympic = $this->repository->findOldOlympic($model->value);
        if (!$olympic) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        if (!$model->isStatusRead()) {
            try {
                $this->service->statusRead($model->id);
            } catch (\DomainException $e) {
                \Yii::$app->errorHandler->logException($e);
                \Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $model,
            'olympic' => $olympic
        ]);
    }
}