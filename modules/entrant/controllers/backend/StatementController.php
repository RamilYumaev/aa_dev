<?php


namespace modules\entrant\controllers\backend;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\mpdf\Pdf;
use Libern\QRCodeReader\QRCodeReader;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\models\Statement;
use modules\entrant\searches\StatementSearch;
use modules\entrant\services\StatementService;
use modules\entrant\services\SubmittedDocumentsService;
use Mpdf\Mpdf;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Yii;
use yii\web\NotFoundHttpException;
use xj\qrcode\QRcode;
use Zxing\QrReader;


class StatementController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function actionIndex()
    {
        $searchModel = new StatementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
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
        $statement = $this->findModel($id);
        $this->render('view', ['statement' => $statement]);
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

        $content = $this->renderPartial('@modules/entrant/views/frontend/statement/pdf/_main', ["statement" => $statement ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileName($statement, '.pdf'));
        return $pdf->render();
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Statement
    {
        if (($model = Statement::findOne(['id'=>$id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }


}