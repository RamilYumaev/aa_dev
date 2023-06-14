<?php


namespace modules\entrant\controllers\backend;


use common\helpers\EduYearHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\AgreementClarifyCgForm;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\AgreementMessageForm;
use modules\entrant\forms\FileMessageForm;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\FileHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\StatementConsentPersonalData;
use modules\entrant\searches\AgreementSearch;
use modules\entrant\searches\StatementCgSearch;
use modules\entrant\services\AgreementService;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AgreementController extends Controller
{
    private $service;

    public function __construct($id, $module, AgreementService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function beforeAction($event)
    {
        if ($this->getJobEntrant()->isStatusDraft()) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    public function actionIndex($status = null)
    {
        $searchModel = new AgreementSearch($status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'status' => $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if ($model->isStatusNew()) {
            try {
                $this->service->addStatus($id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'agreement' => $model,
        ]);
    }

    /* @return  JobEntrant */
    protected function getJobEntrant()
    {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $form = new AgreementMessageForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->addMessage($model->id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $form,
        ]);
    }

    public function actionClarifyCgs($id)
    {
        $model = $this->findModel($id);
        $form = AgreementClarifyCgForm::findOne($model->id);
        if ($form->competitive_list != "") {
            $form->competitive_list = json_decode($form->competitive_list);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $form->competitive_list = json_encode($form->competitive_list);
            $form->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('clarify-cgs', ['model' => $form]);
    }


    /**
     * @param $agreementId
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDataJson($agreementId)
    {
        $agreement = $this->findModel($agreementId);
        $result = DataExportHelper::dataIncomingAgreement($agreement);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Agreement
    {
        if (($model = Agreement::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}