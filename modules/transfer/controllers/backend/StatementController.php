<?php


namespace modules\transfer\controllers\backend;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\search\StatementSearch;
use modules\entrant\services\StatementService;
use modules\transfer\models\StatementTransfer;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class StatementController extends Controller
{
    private $service;

    public function __construct($id, $module,StatementService $service,  $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex($status = null)
    {
        $searchModel = new StatementSearch($status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $status
        ]);
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatus($id, $status)
    {
        $model = $this->findModel($id);
        try {
            $model->setStatus($status);
            $model->save();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatusView($id)
    {
        $model = $this->findModel($id);
        try {
            $model->setStatus(StatementHelper::STATUS_VIEW);
            $model->save();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionDataJson($id) {
        $statement = $this->findModel($id);
        $result = DataExportHelper::dataIncomingStatement($statement->user_id, $statement->id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionMessage($id)
    {
        $model = $this->findModel($id);
        $model->setScenario(StatementTransfer::MESSAGE);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                 $model->setStatus(StatementHelper::STATUS_NO_ACCEPTED);
                 $model->save();
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('message', [
            'model' => $model,
        ]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $statement = $this->findModel($id);
        return $this->render('view', ['statement' => $statement]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $statement = $this->findModel($id);
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/transfer/views/frontend/statement-transfer/pdf/_main', ["statement" => $statement ]);
        $pdf = PdfHelper::generate($content, "Заявление.pdf");
        return $pdf->render();
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementTransfer
    {;

        if (($model = StatementTransfer::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}