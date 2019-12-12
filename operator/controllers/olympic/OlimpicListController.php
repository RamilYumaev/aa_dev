<?php

namespace operator\controllers\olympic;


use olympic\forms\OlimpicListCopyForm;
use olympic\forms\OlimpicListCreateForm;
use olympic\forms\OlimpicListEditForm;
use olympic\forms\search\OlimpicListSearch;
use olympic\helpers\OlympicHelper;
use olympic\models\OlimpicList;
use olympic\services\OlimpicListService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;

class OlimpicListController extends Controller
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
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('@backend/views/olympic/olimpic-list/view', [
            'olympic' => $this->findModel($id),
        ]);
    }

    /**

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlimpicList
    {
        if (($model = OlimpicList::find()->where(['id'=>$id,'olimpic_id'=>OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }



}
