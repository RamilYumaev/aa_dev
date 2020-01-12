<?php

namespace frontend\controllers;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingDeliveryStatusService;
use olympic\readRepositories\PrintReadRepository;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\HttpException;


class PrintController extends Controller
{
    public $layout = 'print';
    private $repository;
    private $service;


    public function __construct($id, $module, PrintReadRepository $repository,
                                SendingDeliveryStatusService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->repository = $repository;
        $this->service = $service;
    }
    /**
     * @return mixed
     */
    public function actionOlimpDocs($template_id, $olympic_id)
    {
        return $this->render('olimp-docs', [
            'result' => $this->repository->getTemplatesAndOlympic($template_id, $olympic_id),
            'olimpiad' => $this->repository->olimpicListRepository->get($olympic_id)]);
    }


    public function actionOlimpResult($olympic_id, $numTour = null, $hash= null)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => $this->repository->getResultOlympic($olympic_id, $numTour),
            'sort' => false,
            'pagination' => false,
        ]);

        if ($hash !== null) {
            $modelSendingDelivery =  SendingDeliveryStatus::find()
                ->hash($hash)
                ->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
                ->typeSending(SendingDeliveryStatusHelper::TYPE_SEND_PRELIMINARY)
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

        return $this->render('olimp-result', [
            'dataProvider' => $dataProvider,
            'numTour'=> $numTour,
            'olimpiad' => $this->repository->olimpicListRepository->get($olympic_id)]);
    }
}