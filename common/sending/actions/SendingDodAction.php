<?php
namespace common\sending\actions;

use common\sending\services\SendingDodProcessService;
use dod\models\DateDod;
use Yii;

class SendingDodAction extends \yii\base\Action
{
    /* @var  DateDod */
    public $model;
    public $service;
    public $typeSending;

    public function __construct($id, $controller, SendingDodProcessService $service, $config = [])
    {
        parent::__construct($id, $controller, $config);
        $this->service= $service;
    }

    public function run()
    {
        set_time_limit(600);
        try {
            $this->service->createAndSend($this->model->id, $this->typeSending);
            return $this->controller->redirect(['index', 'dod_id'=> $this->model->id,
                'typeSending' =>$this->typeSending]);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
            return $this->controller->redirect(Yii::$app->request->referrer);
        }
    }

}