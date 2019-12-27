<?php
namespace frontend\controllers;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingDeliveryStatusService;
use olympic\models\Diploma;
use olympic\readRepositories\OlimpicReadRepository;
use yii\web\Controller;
use yii\web\HttpException;


class DiplomaController extends Controller
{
    public  $layout = 'print';
    private $repository;
    private $service;

    public function __construct($id, $module, OlimpicReadRepository $repository,
                                SendingDeliveryStatusService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }

    public function actionIndex($id, $hash = null)
    {
        $this->layout = '@app/views/layouts/print.php';
        $model =  Diploma::findOne($id);
        if (!$model) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        $olympic = $this->repository->findOldOlympic($model->olimpic_id);
        if (!$olympic) {
            throw new HttpException('404', 'Такой страницы не существует');
        }
        if ($hash !== null) {
            $modelSendingDelivery =  SendingDeliveryStatus::find()
                ->hash($hash)
                ->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
                ->typeSending(SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA)
                ->one();
            if (!$modelSendingDelivery) {
                throw new HttpException('404', 'Такой страницы не существует');
            }
            if (!$modelSendingDelivery->isStatusRead()) {
                try {
                    $this->service->statusRead($modelSendingDelivery->id);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        return $this->render('index', [
            'model' => $model,
            'olympic' => $olympic
        ]);
    }
}