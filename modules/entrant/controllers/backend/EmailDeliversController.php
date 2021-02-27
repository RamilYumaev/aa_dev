<?php

namespace modules\entrant\controllers\backend;


use modules\dictionary\models\JobEntrant;
use modules\entrant\services\EmailDeliverService;
use yii\web\Controller;
use Yii;

class EmailDeliversController extends Controller
{
    private $service;

    public function __construct($id, $module, EmailDeliverService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    public function actionAccepted() {
        try {
            $this->service->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}