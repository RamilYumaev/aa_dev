<?php


namespace backend\controllers\dictionary;


use dictionary\forms\DictSpecializationCreateForm;
use dictionary\forms\DictSpecializationEditForm;
use dictionary\forms\search\DictSpecializationSearch;
use dictionary\models\DictSpecialization;
use dictionary\services\DictSpecializationService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class DictSpecializationController extends Controller
{
    private $service;

    public function __construct($id, $module, DictSpecializationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DictSpecializationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DictSpecializationCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
                return $this->redirect(['index']);
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

        $form = new DictSpecializationEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'specialization' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DictSpecialization
    {
        if (($model = DictSpecialization::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
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
        return $this->redirect(['index']);
    }

}