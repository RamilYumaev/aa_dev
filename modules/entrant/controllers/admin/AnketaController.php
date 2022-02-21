<?php

namespace modules\entrant\controllers\admin;

use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\models\Anketa;
use modules\entrant\searches\admin\AnketaSearch;
use modules\entrant\services\AnketaService;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AnketaController extends Controller
{
    private $service;

    public function __construct($id, $module, AnketaService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex()
    {
        $searchModel = new AnketaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new AnketaForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->update($model->id, $form, true);
                return $this->redirect(['index']);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'anketa'=> $model,
        ]);
    }

    public function actionGetCategory($foreignerStatus, $educationLevel, $universityChoice)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        // return ['result' => $this->service->category($foreignerStatus)];
        return ['result'=> CategoryStruct::datasetQualifier($foreignerStatus, $educationLevel, $universityChoice)];
    }

    public function actionGetAllowEducationLevelByBranch($universityId)
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result'=> AnketaHelper::educationLevelChoice($universityId)];
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Anketa
    {
        if (($model = Anketa::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }
}
