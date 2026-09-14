<?php

namespace modules\transfer\controllers\backend;


use modules\transfer\models\TransferSetting;
use modules\transfer\search\TransferSettingSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SettingController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new TransferSettingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new TransferSetting();

        if ($model->load(Yii::$app->request->post())) {
            $model->finances = $this->prepareJson($model->finances);
            $model->citizenship = $this->prepareJson($model->citizenship);
            $model->semesters = $this->prepareJson($model->semesters);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->finances = $this->prepareJson($model->finances);
            $model->citizenship = $this->prepareJson($model->citizenship);
            $model->semesters = $this->prepareJson($model->semesters);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TransferSetting::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Transfer setting not found.');
    }

    protected function prepareJson($value)
    {
        if (empty($value)) {
            return null;
        }

        // Если уже пришёл JSON
        if (is_string($value)) {
            json_decode($value);

            if (json_last_error() === JSON_ERROR_NONE) {
                return $value;
            }

            // Если введён обычный текст — превращаем в JSON-массив
            $value = array_filter(
                array_map('trim', explode(',', $value))
            );
        }

        return json_encode(
            $value,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
        );
    }
}
