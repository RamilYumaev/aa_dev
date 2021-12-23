<?php


namespace modules\transfer\controllers\frontend;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\helpers\AddressHelper;
use modules\entrant\helpers\DateFormatHelper;
use modules\entrant\helpers\PassportDataHelper;
use modules\entrant\models\PassportData;
use modules\transfer\forms\PacketDocumentUserForm;
use modules\transfer\models\CurrentEducation;
use modules\transfer\models\InsuranceCertificateUser;
use modules\transfer\models\StatementTransfer;
use modules\transfer\services\SubmittedDocumentsService;
use modules\transfer\behaviors\TransferRedirectBehavior;
use modules\transfer\models\TransferMpgu;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

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
        $statement = StatementTransfer::findOne(['user_id'=> $this->getUserId()]);
        $passport = PassportDataHelper::isExits($this->getUserId());
        $address = AddressHelper::isExits($this->getUserId());
        $snils = InsuranceCertificateUser::findOne(['user_id'=> $this->getUserId()]);
        if(!$model) {
            return $this->redirect(['default/index']);
        }
        if(!$passport || !$address || !$snils) {
            Yii::$app->session->setFlash("error", "Заполните, пожалуйста, блоки, отмеченные красным цветом");
            return $this->redirect(['default/index']);
        }

        if(!$model->isMpgu() && !$edu) {
            return $this->redirect(['current-education/index']);
        }

        if(!$statement && !$model->inMpgu()) {
        return $this->redirect(['current-education-info/index']);
        }

        if(!$statement && $model->inMpgu()) {
            return $this->redirect(['default/index']);
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
        } catch (\Exception $e) {
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionAgreementContract()
    {
        return $this->render('agreement-contract');
    }

    public function actionContractSend() {
        try {
            $this->service->transferContractSend($this->getUserId());
            return $this->redirect('/');
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        } catch (\Exception $e) {
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */

    public function actionAdd($id)
    {
        $model = PacketDocumentUserForm::findOne(['id'=>$id, 'user_id' => $this->getUserId()]);
        if(!$model) {
            throw new NotFoundHttpException('Не найдена страница');
        }
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Успешно обновлено');
                return $this->redirect(['index']);
            }
        }else {
            $model->date =  $model->date ? $model->dateRu : "";
        }
        return $this->renderAjax('add', ['model'=> $model]);
    }


    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}