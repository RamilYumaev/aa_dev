<?php


namespace modules\entrant\controllers\frontend;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\OtherDocument;
use modules\entrant\services\OtherDocumentService;
use modules\superservice\components\DynamicGetData;
use modules\superservice\forms\DocumentsDynamicForm;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class OtherDocumentController extends Controller
{
    private $service;
    private $dynamicFormModel;
    public function __construct($id, $module, OtherDocumentService $service, DynamicGetData $dynamicFormModel,
                                $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->dynamicFormModel = $dynamicFormModel;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     *
     * @return mixed
     */

    public function actionCreate()
    {
        $dynamic = $this->dynamicFormModel->dynamicForm();
        $form = new OtherDocumentForm($this->getUserId());
        $this->setTypeAndVersion($form, null);
        $this->formCreateUpdate($form, ['default/index'], null, $dynamic);

       return $this->render('create', ['model' => $form, 'dynamic' => $dynamic]);
    }

    public function actionPatriot()
    {
        $dynamic = $this->dynamicFormModel->dynamicForm();
        $type = DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC;
        $model = $this->findOne(['type'=> $type, 'user_id' => $this->getUserId()]) ?? null;
        $form = new OtherDocumentForm(
            $this->getUserId(),
            false,
            $model,
            false,
            $this->arrayRequired(false),
            [DictIncomingDocumentTypeHelper::TYPE_OTHER], null,['type' => $type]);
        $this->setTypeAndVersion($form, $model);
        $this->formCreateUpdate($form, ['anketa/step2'], $model,  $dynamic);
        return $this->render("patriot", ["model" => $form,  'dynamic' => $dynamic]);
    }

    public function actionExemption()
    {
        $dynamic = $this->dynamicFormModel->dynamicForm();
        $model = OtherDocument::find()->where(['user_id' => $this->getUserId()])->andWhere(['not',['exemption_id'=> null ]])->one() ?? null;
        $form = new OtherDocumentForm(
            $this->getUserId(),
            false,
            $model,
            true,
            $this->arrayRequired(true),
            [DictIncomingDocumentTypeHelper::TYPE_OTHER], null);
        $this->setTypeAndVersion($form, $model);
        $this->formCreateUpdate($form, ['anketa/step2'], $model, $dynamic);
        return $this->render("exemption", ["model" => $form,  'dynamic' => $dynamic]);
    }

    public function actionWithout()
    {
        $dynamic = $this->dynamicFormModel->dynamicForm();
        $model = OtherDocument::find()->where(['user_id' => $this->getUserId()])->andWhere(['not',['without'=> null ]])->one() ?? null;
        $form = new OtherDocumentForm(
            $this->getUserId(),
            false,
            $model,
            false,
            ['series', 'number','authority','date'],
            [DictIncomingDocumentTypeHelper::TYPE_DIPLOMA_WITHOUT], null,['without'=>1]);
        $this->setTypeAndVersion($form, $model);
        $this->formCreateUpdate($form, ['anketa/step2'], $model, $dynamic);
        return $this->render("without", ["model" => $form, 'dynamic' => $dynamic]);
    }


    private function formCreateUpdate(OtherDocumentForm $form,
                                      $urlRedirect,
                                      OtherDocument $model = null,
                                      DocumentsDynamicForm $documentsDynamicForm = null)
    {
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $modelForm = $this->dynamicFormModel->loadData($documentsDynamicForm);
            try {
                if($model) {
                    $this->service->edit($model->id, $form, $modelForm);
                }else {
                    $this->service->create($form, $modelForm);
                }
                return  $this->redirect($urlRedirect);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }

    private function arrayRequired($category){
        if($category) {
            $array =  ['authority','date'];
            array_push($array, 'exemption_id');
        } else {
            $array =  ['series', 'number','authority','date'];
        }
        return $array;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $dynamic = $this->dynamicFormModel->dynamicForm($model->version_document);
        if($model->isPhoto()) {
            Yii::$app->session->setFlash("warning", 'Раздел "Фотографии" нельзя редактировать');
            return $this->redirect(['default/index']);
        }
        $form = new OtherDocumentForm($model->user_id,  false, $model);
        $this->setTypeAndVersion($form, $model);
        $this->formCreateUpdate($form, ['default/index'], $model, $dynamic);
        return $this->render('update', [
            'model' => $form,
            'dynamic' => $dynamic
        ]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdf($id)
    {
        $other = $this->findModel($id);
        if($other->type_note != OtherDocumentHelper::STATEMENT_TARGET) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf', ["other" => $other ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameConsent( ".pdf"));
        $render = $pdf->render();

        return $render;
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfTpgu($id)
    {
        $other = $this->findModel($id);
        if($other->type_note != OtherDocumentHelper::STATEMENT_AGREE_TPGU) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf-tpgu', ["other" => $other ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameTpguAgreement( ".pdf"));
        $render = $pdf->render();

        return $render;
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     * @throws \yii\base\InvalidConfigException
     */

    public function actionPdfWithoutAppendix($id)
    {
        $other = $this->findModel($id);
        if($other->type_note != OtherDocumentHelper::WITHOUT_APPENDIX) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

        $content = $this->renderPartial('pdf-without-appendix', ["other" => $other ]);
        $pdf = PdfHelper::generate($content, FileCgHelper::fileNameWithoutAppendix( ".pdf"));
        $render = $pdf->render();

        return $render;
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OtherDocument
    {
        if (($model = OtherDocument::findOne(['id'=>$id, 'user_id' => $this->getUserId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    protected function findOne(array $condition){
        return OtherDocument::findOne($condition);
    }


    /**
     * @param integer $id
     * @return mixed
     *  @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->isPhoto()) {
            Yii::$app->session->setFlash("warning", 'Раздел "Фотографии" нельзя удлаять');
           return $this->redirect(Yii::$app->request->referrer);
        }
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    private function setTypeAndVersion(OtherDocumentForm $form, OtherDocument $model = null) {
        if($model)  {
            $form->type_document = \Yii::$app->request->get('type') ?? $model->type_document;
            $form->version_document = \Yii::$app->request->get('version') ?? $model->version_document;
        }else {
            $form->type_document = \Yii::$app->request->get('type');
            $form->version_document = \Yii::$app->request->get('version');
        }
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}