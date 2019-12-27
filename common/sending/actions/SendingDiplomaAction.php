<?php
namespace common\sending\actions;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingProcessService;
use olympic\models\OlimpicList;
use yii\data\ActiveDataProvider;
use Yii;

class SendingDiplomaAction extends \yii\base\Action
{
    /* @var  $olympicModel OlimpicList */
    public $olympicModel;
    public $service;

    public function __construct($id, $controller, SendingProcessService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service= $service;
    }

    public function run()
    {
        try {
            $this->service->createAndSend($this->olympicModel->id);
            return $this->controller->redirect(['index',
                'olympic_id'=> $this->olympicModel->id,
                'typeSending' =>SendingDeliveryStatusHelper::TYPE_SEND_DIPLOMA]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
    }

}