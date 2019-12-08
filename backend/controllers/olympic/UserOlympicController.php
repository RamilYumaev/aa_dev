<?php
namespace backend\controllers\olympic;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\forms\search\OlympicSearch;
use olympic\models\OlimpicList;
use olympic\models\Olympic;
use olympic\models\UserOlimpiads;
use Yii;
use olympic\services\OlympicService;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserOlympicController extends Controller
{

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionIndex($olympic_id)
    {
        $olympic = $this->findModel($olympic_id);
        $model =  UserOlimpiads::find()->where(['olympiads_id'=>$olympic->id]);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'olympic' => $olympic
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlimpicList
    {
        if (($model = OlimpicList::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}