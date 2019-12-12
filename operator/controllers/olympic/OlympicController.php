<?php
namespace operator\controllers\olympic;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\forms\search\OlympicSearch;
use olympic\models\Olympic;
use Yii;
use olympic\services\OlympicService;
use yii\bootstrap\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class OlympicController extends Controller
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

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('@backend/views/olympic/olympic/view', [
            'olympic' => $this->findModel($id),
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): Olympic
    {
        if (($model = Olympic::find()->id($id)->manager(Yii::$app->user->identity->getId())->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы нет.');
    }
}