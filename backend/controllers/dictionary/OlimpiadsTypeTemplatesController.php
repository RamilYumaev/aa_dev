<?php


namespace backend\controllers\dictionary;

use dictionary\forms\OlimpiadsTypeTemplatesCreateForm;
use dictionary\forms\OlimpiadsTypeTemplatesEditForm;
use dictionary\models\OlimpiadsTypeTemplates;
use Yii;
use dictionary\services\OlimpiadsTypeTemplatesService;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OlimpiadsTypeTemplatesController extends Controller
{
    private $service;

    public function __construct($id, $module, OlimpiadsTypeTemplatesService $service, $config = [])
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
        $query = OlimpiadsTypeTemplates::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new OlimpiadsTypeTemplatesCreateForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->create($form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $number_of_tours
     * @param $form_of_passage
     * @param $edu_level_olimp
     * @param $template_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        $model = $this->findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);
        $form = new OlimpiadsTypeTemplatesEditForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($form, $number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update', [
            'model' => $form,
            'olimpiadsTypeTemplates' => $model,
        ]);
    }

    /**
     * @param $number_of_tours
     * @param $form_of_passage
     * @param $edu_level_olimp
     * @param $template_id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id): OlimpiadsTypeTemplates
    {
        if (($model = OlimpiadsTypeTemplates::findOne(['number_of_tours'=>$number_of_tours,
                'form_of_passage'=>$form_of_passage, 'edu_level_olimp'=>$edu_level_olimp, 'template_id'=> $template_id])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param $number_of_tours
     * @param $form_of_passage
     * @param $edu_level_olimp
     * @param $template_id
     * @return mixed
     */
    public function actionDelete($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id)
    {
        try {
            $this->service->remove($number_of_tours, $form_of_passage, $edu_level_olimp, $template_id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

}