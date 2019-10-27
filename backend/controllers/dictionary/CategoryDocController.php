<?php

namespace backend\controllers\dictionary;

use dictionary\models\CategoryDoc;
use dictionary\forms\CategoryDocForm;
use dictionary\forms\search\CategoryDocSearch;
use dictionary\services\CategoryDocService;
use yii\web\Controller;
use Yii;
use yii\filters\VerbFilter;

class CategoryDocController extends Controller
{
    private $service;

    public function __construct($id, $module, CategoryDocService $service, $config = [])
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
        $searchModel = new CategoryDocSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'catDoc' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new CategoryDocForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $catDoc = $this->service->create($form);
                return $this->redirect(['view', 'id' => $catDoc->id]);
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
     */
    public function actionUpdate($id)
    {
        $catDoc = $this->findModel($id);

        $form = new CategoryDocForm($catDoc);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($catDoc->id, $form);
                return $this->redirect(['view', 'id' => $catDoc->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'catDoc' => $catDoc,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    protected function findModel($id): CategoryDoc
    {
        if (($model = CategoryDoc::findOne($id)) !== null) {
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
