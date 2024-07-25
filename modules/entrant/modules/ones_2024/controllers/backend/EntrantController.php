<?php
namespace modules\entrant\modules\ones_2024\controllers\backend;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\modules\ones_2024\forms\search\CgSSSearch;
use modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch;
use modules\entrant\modules\ones_2024\forms\search\EntrantSearch;
use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use Yii;
use yii\base\ExitException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EntrantController extends Controller
{
    public function behaviors(): array
    {
        return [
            [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }

    public function beforeAction($event)
    {
        if($this->getJobEntrant()->isStatusDraft() || !in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK()) ) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EntrantSearch($this->getJobEntrant()) ;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): EntrantSS
    {
        if (($model = EntrantSS::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}
