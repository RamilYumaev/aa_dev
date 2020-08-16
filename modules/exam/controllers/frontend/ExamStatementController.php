<?php


namespace modules\exam\controllers\frontend;

use modules\entrant\models\AdditionalInformation;
use modules\entrant\services\AdditionalInformationService;
use modules\exam\behaviors\ExamRedirectBehavior;
use modules\exam\helpers\ExamCgUserHelper;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\services\ExamStatementService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ExamStatementController extends Controller
{
    private $service;

    public function __construct($id, $module, ExamStatementService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    public function behaviors()
    {
        return [
            ExamRedirectBehavior::class,
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'register' => ['POST'],
                    'register-za' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @param $examId
     * @return mixed
     */
    public function actionRegister($examId)
    {
        try {
            $this->service->register($examId, $this->getUserId(), ExamStatementHelper::USUAL_TYPE_OCH);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $examId
     * @return mixed
     */
    public function actionRegisterZa($examId)
    {
        try {
            $this->service->register($examId, $this->getUserId(), ExamStatementHelper::USUAL_TYPE_ZA_OCH);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }

}