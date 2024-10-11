<?php
namespace backend\controllers\olympic;

use olympic\forms\search\OlympicSpecialityProfileSearch;
use olympic\forms\search\OlympicSpecialitySearch;
use olympic\models\OlympicSpeciality;
use olympic\models\OlympicSpecialityProfile;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OlympicSpecialityProfileController extends Controller
{
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
        $searchModel = new OlympicSpecialityProfileSearch();
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
        $form = new OlympicSpecialityProfile();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('form', [
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
        $form = $this->findModel($id);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('form', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlympicSpecialityProfile
    {
        if (($model = OlympicSpecialityProfile::findOne($id)) !== null) {
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
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index']);
    }
}
