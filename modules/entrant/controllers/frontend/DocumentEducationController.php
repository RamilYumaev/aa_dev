<?php


namespace modules\entrant\controllers\frontend;

use modules\entrant\forms\DocumentEducationForm;
use modules\entrant\models\DocumentEducation;
use modules\entrant\services\DocumentEducationService;
use modules\superservice\components\DynamicGetData;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class DocumentEducationController extends Controller
{
    private $service;

    public function __construct($id, $module, DocumentEducationService $service, $config = [])
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
        $this->findModelIsUser();
        $form = new DocumentEducationForm($this->getUserId());
        $this->setTypeAndVersion($form);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form, $this->getAnketa());
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
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
        $form = new DocumentEducationForm($model->user_id,$model);
        $this->setTypeAndVersion($form, $model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form, $this->getAnketa());
                return $this->redirect(['default/index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DocumentEducation
    {
        if (($model = DocumentEducation::findOne(['id'=>$id, 'user_id' => $this->getUserId()])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /**
     * @return mixed
     */
    protected function findModelIsUser()
    {
        $model  = DocumentEducation::findOne(['user_id' => $this->getUserId()]);
        if($model) {
            return $this->redirect(['update', 'id'=> $model->id]);
        }
    }

    public function getAnketa()
    {
        if($anketa = \Yii::$app->user->identity->anketa())
        {
            return $anketa;
        }
        return $this->redirect('default/index');
    }

    private function setTypeAndVersion(DocumentEducationForm $form, DocumentEducation $model = null) {
        if($model)  {
            $form->type_document = \Yii::$app->request->get('type') ?? $model->type_document;
            $form->version_document = \Yii::$app->request->get('version') ?? $model->version_document;
        }else {
            $form->type_document = \Yii::$app->request->get('type');
            $form->version_document = \Yii::$app->request->get('version');
        }
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
        return $this->redirect(['default/index']);
    }

    private function getUserId()
    {
        return  Yii::$app->user->identity->getId();
    }
}