<?php


namespace modules\transfer\controllers\backend;
use modules\dictionary\models\JobEntrant;
use modules\entrant\forms\StatementMessageForm;
use modules\entrant\helpers\DataExportHelper;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\StatementHelper;
use modules\transfer\models\PassExam;
use modules\transfer\search\PassExamSearch;
use modules\transfer\search\StatementSearch;
use modules\entrant\services\StatementService;
use modules\transfer\models\StatementTransfer;
use yii\base\ExitException;
use yii\bootstrap\ActiveForm;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;


class PassExamController extends Controller
{
    private $service;

    public function __construct($id, $module,StatementService $service,  $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex($type = null, $protocol = null)
    {
        $searchModel = new PassExamSearch($type, $protocol);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'status' => $type
        ]);
    }

    /**
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionSuccess($id)
    {
        $statement = $this->findModel($id);
        try {
            $this->isPassExam($statement);
            $model = new PassExam();
            $model->statement_id = $statement->id;
            $model->is_pass = PassExam::SUCCESS;
            $model->save();
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function isPassExam(StatementTransfer $statementTransfer) {
        if($statementTransfer->passExam) {
            throw  new \DomainException('Запись к аттестации существует');
        }
    }

    /**
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionDanger($id)
    {
        $statement = $this->findModel($id);
        $model = new PassExam();
        $model->setScenario(PassExam::MESSAGE);
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            try {
                $this->isPassExam($statement);
                $model->statement_id = $statement->id;
                 $model->is_pass = PassExam::DANGER;
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

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
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