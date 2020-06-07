<?php


namespace modules\entrant\controllers\frontend;
use modules\entrant\forms\LegalEntityForm;
use modules\entrant\forms\PersonalEntityForm;
use modules\entrant\helpers\FileCgHelper;
use modules\entrant\helpers\PdfHelper;
use modules\entrant\models\LegalEntity;
use modules\entrant\models\PersonalEntity;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\services\StatementAgreementContractCgService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class StatementAgreementContractCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementAgreementContractCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
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
     * @param integer $id
     * @return mixed
     */
    public function actionCreate($id)
    {
        try {
            $this->service->create($id, $this->getUser());
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
        if($agreement->typeEntrant() || $agreement->typePersonal() || $agreement->typeLegal()) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
            Yii::$app->response->headers->add('Content-Type', 'image/jpeg');

            $content = $this->renderPartial('pdf/_main', ["agreement" => $agreement]);
            $pdf = PdfHelper::generate($content, FileCgHelper::fileNameAgreement(".pdf"));
            $render = $pdf->render();

            try {
                $this->service->addCountPages($id, count($pdf->getApi()->pages));
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $render;
        }else {
            Yii::$app->session->setFlash('warning', "Вы не выбрали заказчика или отсуствуют их данные");
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */


    public function actionForm($id)
    {
        $agreement= $this->findModel($id);
         if($agreement->type == 1) {
             return $this->redirect(Yii::$app->request->referrer);
         }elseif($agreement->type == 2) {
             $model = PersonalEntity::findOne($agreement->record_id) ?? null;
             $form = new PersonalEntityForm($this->getUser(), $model);
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                     $this->service->createOrUpdatePersonal($form, $agreement->id);
                     return $this->redirect(['post-document/consent-rejection']);
                 } catch (\DomainException $e) {
                     Yii::$app->errorHandler->logException($e);
                     Yii::$app->session->setFlash('error', $e->getMessage());
                 }
             }
             return $this->render('_form_personal', [
                 'model' => $form,
             ]);
         }elseif($agreement->type == 3) {
             $model = LegalEntity::findOne($agreement->record_id) ?? null;
             $form = new LegalEntityForm($this->getUser(), $model);
             if ($form->load(Yii::$app->request->post()) && $form->validate()) {
                 try {
                     $this->service->createOrUpdateLegal($form, $agreement->id);
                     return $this->redirect(['post-document/consent-rejection']);
                 } catch (\DomainException $e) {
                     Yii::$app->errorHandler->logException($e);
                     Yii::$app->session->setFlash('error', $e->getMessage());
                 }
             }
             return $this->render('_form_legal', [
                 'model' => $form,
             ]);
         }
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): StatementAgreementContractCg
    {
        if (($model = StatementAgreementContractCg::find()->statementOne($id, $this->getUser())) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id, $this->getUser());
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionAdd($id)
    {
        $customer = Yii::$app->request->post('customer');
        $agreement = $this->findModel($id);
        if ($customer) {
            try {
                $statement = $this->service->add($agreement->id, $customer);
                return $this->redirect(['form', 'id' => $statement->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());

                return $this->redirect(Yii::$app->request->referrer);
            }

        }
        return $this->renderAjax('add',['type' => $agreement->type]);
    }



    private function  getUser() {
       return Yii::$app->user->identity->getId();
    }


}