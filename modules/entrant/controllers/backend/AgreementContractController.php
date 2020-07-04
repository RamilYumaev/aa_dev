<?php


namespace modules\entrant\controllers\backend;


use common\helpers\EduYearHelper;
use modules\entrant\forms\AgreementForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\entrant\searches\StatementAgreementContractSearch;
use modules\entrant\searches\StatementConsentSearch;
use modules\entrant\services\AgreementService;
use modules\entrant\services\StatementAgreementContractCgService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class AgreementContractController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementAgreementContractCgService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @param null $status
     * @return mixed
     */
    public function actionIndex($status = null)
    {
        $searchModel = new StatementAgreementContractSearch($status);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'status'=> $status,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $contract = $this->findModel($id);
        return $this->render('view', ['contract' => $contract]);
    }

    /**
     *
     * @param $id
     * @param $status
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionStatus($id, $status)
    {
        $contract = $this->findModel($id);
        try {
            $this->service->status($contract->id, $status);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
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
        $agreement= $this->findModel($id);

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('@modules/entrant/views/frontend/
        statement-agreement-contract-cg/pdf/_main', ["agreement" => $agreement,
            "anketa"=> $agreement->statementCg->statement->profileUser->anketa]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameAgreement(".pdf"));
        $render = $pdf->render();
        return $render;
    }



    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementAgreementContractCg
    {;

        if (($model = StatementAgreementContractCg::findOne($id))  !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
