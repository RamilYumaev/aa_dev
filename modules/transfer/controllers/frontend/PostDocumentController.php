<?php


namespace modules\transfer\controllers\frontend;
use modules\transfer\models\CurrentEducation;
use modules\transfer\models\StatementTransfer;
use modules\transfer\services\SubmittedDocumentsService;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;
use Yii;

class PostDocumentController extends Controller
{
    private $service;

    public function __construct($id, $module, SubmittedDocumentsService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors()
    {
        return [
            [
                'class'=> TransferRedirectBehavior::class,
                'ids'=>['index' ]
            ]
        ];
    }


    public function actionIndex()
    {
        $model =  TransferMpgu::findOne(['user_id'=> $this->getUserId()]);
        $edu = CurrentEducation::findOne(['user_id'=> $this->getUserId()]);
        $statement =  StatementTransfer::findOne(['user_id'=> $this->getUserId()]);
        if(!$model) {
            return $this->redirect('default/index');
        }

        if(!$model->isMpgu() && !$edu) {
            return $this->redirect('current-education/index');
        }

        if(!$statement) {
        return $this->redirect('current-education-info/index');
    }



        return $this->render('index',['transfer' => $model]);
    }

    public function actionSend() {
        try {
            $this->service->transferSend($this->getUserId());
            return $this->redirect('/');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionRecordSend() {
        try {
            $this->service->sendRecord($this->getUserId());
            return $this->redirect('/');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param integer $type
     * @return mixed
     */
    private function serviceSave($type) {

        try {
            $this->service->create($type, $this->getUserId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }


}