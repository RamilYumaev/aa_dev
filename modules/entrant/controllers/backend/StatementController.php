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

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-cg' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionDoc($id)
    {
        $statement = $this->findModel($id);
        FileCgHelper::getFile(Yii::$app->user->identity->getId(), $statement);
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

        $content = $this->renderPartial('pdf/_main', ["statement" => $statement ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileName($statement, '.pdf'));
        $render = $pdf->render();
        try {
            $this->service->addCountPages($id, count($pdf->getApi()->pages));
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $render;

    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Statement
    {
        if (($model = Statement::findOne(['id'=>$id, 'user_id' => Yii::$app->user->identity->getId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteCg($id)
    {
        try {
            $this->service->remove($id, Yii::$app->user->identity->getId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }


}