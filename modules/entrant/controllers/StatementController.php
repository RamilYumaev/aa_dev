<?php


namespace modules\entrant\controllers;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\models\Statement;
use modules\entrant\services\StatementService;
use modules\entrant\services\SubmittedDocumentsService;
use Mpdf\Mpdf;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
use Yii;
use yii\web\NotFoundHttpException;


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

         $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8,
                'filename' => FileCgHelper::fileName($statement, '.pdf'),
                // A4 paper format
                'format' => Pdf::FORMAT_A4,
                // portrait orientation
                'orientation' => Pdf::ORIENT_PORTRAIT,
                // stream to browser inline
                'destination' => Pdf::DEST_DOWNLOAD,
                // your html content input
                'content' => $content,
                // format content from your own css file if needed or use the
                // enhanced bootstrap css built by Krajee for mPDF formatting
                'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.css',
                // any css to be embedded if required
                'cssInline' => '.kv-heading-1{font-size:18px}',
                 // set mPDF properties on the fly
                'options' => ['title' => 'Krajee Report Title'],
                 // call mPDF methods on the fly
                'methods' => [
                    //'SetHeader'=>['Krajee Report Header'],
                    'SetFooter'=>['{PAGENO}'],
                ]
            ]);

        return $pdf->render();
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