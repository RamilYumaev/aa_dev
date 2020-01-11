<?php
namespace common\sending\actions;

use common\sending\services\SendingProcessService;
use olympic\models\OlimpicList;
use Yii;

class SendingAction extends \yii\base\Action
{
    /* @var  $olympicModel OlimpicList */
    public $olympicModel;
    public $service;
    public $typeSending;

    public function __construct($id, $controller, SendingProcessService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service= $service;
    }

    public function run()
    {
        try {
            $this->service->createAndSend($this->olympicModel->id, $this->typeSending);
            return $this->controller->redirect(['index', 'olympic_id'=> $this->olympicModel->id,
                'typeSending' =>$this->typeSending]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
    }

}