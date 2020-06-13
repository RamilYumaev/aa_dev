<?php


namespace modules\entrant\controllers\backend;


use common\helpers\EduYearHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\AgreementForm;
use modules\entrant\forms\AgreementMessageForm;
use modules\entrant\forms\FileMessageForm;
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

//    public function beforeAction($event)
//    {
//        if(!$this->jobEntrant->isCategoryTarget()) {
//            Yii::$app->session->setFlash("warning", 'Страница недоступна');
//            Yii::$app->getResponse()->redirect(['site/index']);
//            try {
//                Yii::$app->end();
//            } catch (ExitException $e) {
//            }
//        }
//        return true;
//    }

    public function actionIndex()
    {
        $searchModel = new AgreementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        return $this->render('view', [
            'agreement' => $model,
        ]);
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
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