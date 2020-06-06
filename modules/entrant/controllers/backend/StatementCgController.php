<?php


namespace modules\entrant\controllers\backend;
use Codeception\Lib\Di;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\readRepositories\StatementCgReadRepository;
use modules\entrant\searches\StatementCgSearch;
use modules\entrant\services\StatementConsentCgService;
use yii\base\ExitException;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class StatementCgController extends Controller
{
    private $service;

    public function __construct($id, $module, StatementConsentCgService $service, $config = [])
    {
        $this->service = $service;
        parent::__construct($id, $module, $config);
    }

    public function beforeAction($event)
    {
        if(!in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesZUK())) {
            Yii::$app->session->setFlash("warning", 'Страница недоступна');
            Yii::$app->getResponse()->redirect(['site/index']);
            try {
                Yii::$app->end();
            } catch (ExitException $e) {
            }
        }
        return true;
    }

    public function actionIndex()
    {
        $searchModel = new StatementCgSearch($this->jobEntrant);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @param $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionView($id)
    {
        $model = $this->findModelAll($id);
        $cg = $this->findModel($id);
        return $this->render('view', ['statementCg' => $model, 'cg'=> $cg]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModelAll($id)
    {
        $query = (new StatementCgReadRepository($this->jobEntrant))->readData()->andWhere(['cg_id'=> $id]);
        $model = clone $query;
        if ($query->exists()) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): DictCompetitiveGroup
    {
        if (($model = DictCompetitiveGroup::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }



}