<?php


namespace modules\entrant\controllers\frontend;

use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\DictIncomingDocumentTypeHelper;
use modules\entrant\forms\PassportDataForm;
use modules\entrant\models\PassportData;
use modules\entrant\services\PassportDataService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class PassportDataController extends Controller
{
    private $service;

    public function __construct($id, $module, PassportDataService $service, $config = [])
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
     * @return mixed
     */
    public function actionCreate()
    {
        $referrer = Yii::$app->request->get("referrer");
        $form = new PassportDataForm($this->getUserId(), null, $this->getAnketa());
        $this->setTypeAndVersion($form);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                if($referrer) {
                    return $this->redirect('/transfer/default/index');
                }
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'neededCountry' => false,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */

    public function actionCreateBirthDocument()
    {
        $form = new PassportDataForm($this->getUserId(), null, $this->getAnketa(), ['nationality', 'number', 'date_of_issue', 'authority','date_of_birth']);
        $form->type = DictIncomingDocumentTypeHelper::ID_BIRTH_DOCUMENT;
        $form->date_of_birth = \date("d.m.Y",strtotime($this->findPassportDateBirth())) ?? null;
        $form->nationality = DictCountryHelper::RUSSIA;
        $this->setTypeAndVersion($form);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, true);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
            'neededCountry' => true,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $referrer = Yii::$app->request->get("referrer");
        $form = new PassportDataForm($model->user_id, $model, $this->getAnketa());
        $this->setTypeAndVersion($form, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                if($referrer) {
                    return $this->redirect('/transfer/default/index');
                }
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'neededCountry' => false,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */

    public function actionUpdateBirthDocument($id)
    {
        $model = $this->findModel($id);
        $form = new PassportDataForm($model->user_id, $model, $this->getAnketa(),['nationality', 'number', 'date_of_issue', 'authority']);
      //  $form->date_of_birth = null;
        $this->setTypeAndVersion($form, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form, true);
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'neededCountry' => true,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): PassportData
    {
        if (($model = PassportData::findOne(['id' => $id, 'user_id' => $this->getUserId()])) !== null) {
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
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    private function getUserId()
    {
        if(!Yii::$app->user->identity->getId()){
          return $this->redirect('/account/login');
        }
        return Yii::$app->user->identity->getId();
    }

    private function setTypeAndVersion(PassportDataForm $form, PassportData $model = null)
    {
        if ($model) {
            $form->type_document = \Yii::$app->request->get('type') ?? $model->type_document;
            $form->version_document = \Yii::$app->request->get('version') ?? $model->version_document;
        } else {
            $form->type_document = \Yii::$app->request->get('type');
            $form->version_document = \Yii::$app->request->get('version');
        }
    }

    private function findPassportDateBirth()
    {
       $passport = PassportData::find()->andWhere(['user_id'=>$this->getUserId()])->andWhere(['main_status'=>true])->one();
       return $passport->date_of_birth;
    }

    private function getAnketa() {
        return Yii::$app->user->identity->anketa();
    }
}