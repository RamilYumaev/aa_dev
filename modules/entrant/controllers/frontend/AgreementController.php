<?php


namespace modules\entrant\controllers\frontend;


use common\helpers\EduYearHelper;
use modules\dictionary\forms\DictOrganizationForm;
use modules\dictionary\models\DictOrganizations;
use modules\dictionary\searches\DictOrganizationsSearch;
use modules\dictionary\services\DictOrganizationService;
use modules\entrant\forms\AgreementForm;
use modules\entrant\models\Agreement;
use modules\entrant\services\AgreementService;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class AgreementController extends Controller
{
    private $service;
    private $dictOrganizationService;

    public function __construct($id, $module, AgreementService $service, DictOrganizationService $dictOrganizationService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->dictOrganizationService = $dictOrganizationService;
    }
    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $model = $this->findModel();
        if(!$model  || !$model->organization || !$model->organizationWork)  {
            Yii::$app->session->setFlash('info', 'Вам необходимо найти, или добаивть организацию нанимателя/работодателя');
            return $this->redirect(['select-organization']);
        }
        $form = new AgreementForm($this->getUserId(), $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->createOrUpdate($form, $model);
                return $this->redirect(['anketa/step2']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('index', [
            'model' => $form,
            'agreement' => $model
        ]);
    }

    protected function findModel(): ?Agreement
    {
      return Agreement::findOne([ 'user_id' => Yii::$app->user->identity->getId(), 'year' =>EduYearHelper::eduYear()]);
    }

    private function getUserId()
    {
        if($userId = \Yii::$app->user->identity->getId())
        {
           return  $userId;
        };
        return $this->redirect("default/index");
    }

    public function actionSelectOrganization() {
        $searchModel = new DictOrganizationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'agreement' => $this->findModel()
        ]);
    }

    public function actionAddOrganization() {
        $form = new DictOrganizationForm(null, true);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->dictOrganizationService->create($form);
                $agreement =  $this->findModel();
                $this->service->addOrganization($model->id, $form->type, $this->getUserId(), $agreement);
                if($form->type == 2) {
                    return $this->redirect(['index']);
                }
                return $this->redirect(['select-organization']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('add', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionEditOrganization($id) {
        if(($model = DictOrganizations::findOne($id))  == null) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
        $form = new DictOrganizationForm($model, true);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->dictOrganizationService->edit($model->id, $form);
                $agreement =  $this->findModel();
                $this->service->addOrganization($model->id, $form->type, $this->getUserId(), $agreement);
                if($form->type == 2) {
                    return $this->redirect(['index']);
                }
                return $this->redirect(['select-organization']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('edit', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @param $status
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionSelect($id, $status) {
        if(($model = DictOrganizations::findOne($id))  == null) {
            throw new NotFoundHttpException('Такой страницы не существует.');
        }
            try {
                $agreement =  $this->findModel();
                 $this->service->addOrganization($model->id, $status, $this->getUserId(),  $agreement);
                if($status == 2) {
                    return $this->redirect(['index']);
                }
                return $this->redirect(['select-organization']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
}