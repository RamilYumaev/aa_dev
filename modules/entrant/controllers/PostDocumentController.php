<?php


namespace modules\entrant\controllers;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use kartik\mpdf\Pdf;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PostDocumentHelper;
use modules\entrant\services\SubmittedDocumentsService;
use Mpdf\Mpdf;
use yii\filters\VerbFilter;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Settings;
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

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'online' => ['POST'],
                    'visit' => ['POST'],
                    'mail' => ['POST'],
                    'ecp' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action)
    {
        if(!PostDocumentHelper::isCorrectBlocks()) {
            Yii::$app->session->setFlash("error", "Не заполнены некоторые блоки");
            Yii::$app->getResponse()->redirect(['abiturient/default/index']);
            Yii::$app->end();
        }
        try {
            return parent::beforeAction($action);
        } catch (BadRequestHttpException $e) {
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @return mixed
     */
    public function actionOnline()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_ONLINE);
    }

    /**
     * @return mixed
     */
    public function actionMail()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_MAIL);
    }

    /**
     * @return mixed
     */
    public function actionVisit()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_VISIT);
    }


    /**
     * @return mixed
     */
    public function actionEcp()
    {
        return $this->serviceSave(PostDocumentHelper::TYPE_ECP);
    }

    /**
     *
     * @param $faculty
     * @param $speciality
     * @param $edu_level
     * @param null $special_right_id
     * @throws NotFoundHttpException
     */
    public function actionDoc($faculty, $speciality, $edu_level, $special_right_id=null)
    {
        if (!DictCompetitiveGroupHelper::facultySpecialityExistsUser(Yii::$app->user->identity->getId(),
            $faculty, $speciality,
            $edu_level, $special_right_id)) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }

        FileCgHelper::getFile(Yii::$app->user->identity->getId(),
            $faculty, $speciality,
            $edu_level, $special_right_id);
    }

    /**
     *
     * @param $faculty
     * @param $speciality
     * @param $edu_level
     * @param null $special_right_id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($faculty, $speciality, $edu_level, $special_right_id=null)
    {
        if (!DictCompetitiveGroupHelper::facultySpecialityExistsUser(Yii::$app->user->identity->getId(),
            $faculty, $speciality,
            $edu_level, $special_right_id)) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'application/pdf');

        $content = $this->renderPartial('pdf/_main', ["faculty" => $faculty, 'speciality' => $speciality,
            'edu_level' => $edu_level,'special_right_id' => $special_right_id, 'user_id' => Yii::$app->user->identity->getId()]);

         $pdf = new Pdf([
                // set to use core fonts only
                'mode' => Pdf::MODE_UTF8,
                'filename' => FileCgHelper::fileName($edu_level, $special_right_id, '.pdf'),
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
     * @param integer $type
     * @return mixed
     */

    private function serviceSave($type) {

        try {
            $this->service->create($type, Yii::$app->user->identity->getId());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


}