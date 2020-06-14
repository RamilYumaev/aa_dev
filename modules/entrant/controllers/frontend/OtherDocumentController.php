<?php


namespace modules\entrant\controllers\frontend;

use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\OtherDocumentForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\OtherDocumentHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\OtherDocument;
use modules\entrant\services\OtherDocumentService;
use yii\base\Model;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class OtherDocumentController extends Controller
{
    private $service;

    public function __construct($id, $module, OtherDocumentService $service, $config = [])
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
       $form = new OtherDocumentForm($this->getUserId());
       $this->formCreateUpdate($form, ['default/index']);
       return $this->render('create', ['model' => $form]);
    }

    public function actionPatriot()
    {
        $type = DictIncomingDocumentTypeHelper::ID_PATRIOT_DOC;
        $model = $this->findOne(['type'=> $type, 'user_id' => $this->getUserId()]) ?? null;
        $form = new OtherDocumentForm(
            $this->getUserId(),
            false,
            $model,
            false,
            $this->arrayRequired(false),
            [DictIncomingDocumentTypeHelper::TYPE_OTHER], null,['type' => $type]);
        $this->formCreateUpdate($form, ['anketa/step2'], $model);
        return $this->render("patriot", ["model" => $form]);
    }

    public function actionExemption()
    {   $model = $this->findOne(['exemption_id'=> true, 'user_id' => $this->getUserId()]) ?? null;
        $form = new OtherDocumentForm(
            $this->getUserId(),
            false,
            $model,
            true,
            $this->arrayRequired(true),
            [DictIncomingDocumentTypeHelper::TYPE_OTHER]);
        $this->formCreateUpdate($form, ['anketa/step2'], $model);
        return $this->render("exemption", ["model" => $form]);
    }

    private function formCreateUpdate(OtherDocumentForm $form, $urlRedirect, OtherDocument $model = null)
    {
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                if($model) {
                    $this->service->edit($model->id, $form);
                }else {
                    $this->service->create($form);
                }
                return  $this->redirect($urlRedirect);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
    }

    private function arrayRequired($category){
        $array =  ['series', 'number', 'authority','date'];
        if($category) {
            array_push($array, 'exemption_id');
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
        if($model->isPhoto()) {
            Yii::$app->session->setFlash("warning", 'Раздел "Фотографии" нельзя редактировать');
            return $this->redirect(['default/index']);
        }
        $form = new OtherDocumentForm($model->user_id,  false, $model);
        $this->formCreateUpdate($form, ['default/index'], $model);
        return $this->render('update', [
            'model' => $form,
        ]);
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


    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}