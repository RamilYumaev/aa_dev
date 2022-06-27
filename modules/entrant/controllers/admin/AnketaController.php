<?php

namespace modules\entrant\controllers\admin;

use modules\entrant\forms\AnketaForm;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\models\Anketa;
use modules\entrant\models\File;
use modules\entrant\searches\admin\AnketaSearch;
use modules\entrant\services\AnketaService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AnketaController extends Controller
{
    private $service;

    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete-data' => ['POST'],
                ],
            ],
        ];
    }

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
        if($model->profile->aisUser) {
            Yii::$app->session->setFlash('warning', 'Нельзя редактировать данные, так как они были экспортированы');
            return $this->redirect(['index']);

        }
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

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteData($id)
    {
        $model = $this->findModel($id);
        if($model->profile->aisUser) {
            Yii::$app->session->setFlash('warning', 'Нельзя редактировать данные, так как они были экспортированы');
            return $this->redirect(['index']);
        }
        foreach (File::find()->user($model->user_id)->all() as $file) {
            $file->delete();
        }
        $model->category_id = null;
        $model->citizenship_id = null;
        $model->current_edu_level = null;
        $model->save(false);
        Yii::$app->session->setFlash('warning', 'Данные очищены');
        return $this->redirect(['index']);
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
