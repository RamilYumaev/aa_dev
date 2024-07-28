<?php
namespace modules\entrant\modules\ones_2024\controllers\backend;

use common\components\TbsWrapper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\CompetitionList;
use modules\dictionary\models\JobEntrant;
use modules\entrant\modules\ones_2024\forms\search\CgSSSearch;
use modules\entrant\modules\ones_2024\job\CompetitionListEpkJob;
use modules\entrant\modules\ones_2024\job\UpdateListEpkJob;
use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\EpkSearch;
use Yii;
use yii\base\ExitException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CgController extends Controller
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
        $searchModel = new CgSSSearch($this->getJobEntrant()) ;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CgSS();
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     *
     * @return mixed
     */
    public function actionUpdateFok($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        if ($model->load($data) && $model->validate()) {
            $model->save();
            $queue = Yii::$app->queue;
            $queue->ttr(20000);
            $message = 'Задание отправлено в очередь';
            $queue->push(new UpdateListEpkJob(['model'=> $model]));
            Yii::$app->session->setFlash("info", $message);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('update-fok', [
            'model' => $model,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = Yii::$app->request->post();
        if($model->load($data) && $model->validate()) {
            $model->save();
            return $this->redirect(['view', 'id'=> $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id, $different = null)
    {
        $model = $this->findModel($id);
        $searchModel = new EpkSearch($model->getList());
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGet($id)
    {
        $model = $this->findModel($id);
        $filePath = $model->getUploadedFilePath('file');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        return Yii::$app->response->sendFile($filePath);
    }


    public function actionGetListEpk($id)
    {
        $model = $this->findModel($id);
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new CompetitionListEpkJob(['model'=>$model]));

        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect(['view', 'id' => $model->id]);
    }


    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionTableFile($id, $fok = null)
    {
        $model = $this->findModel($id);
        $list = $fok == 1 ? $model->getListFok() : $model->getList();
        $fileName = $model->name.".xlsx";
        $filePath =  \Yii::getAlias('@common').'/file_templates/list_ss.xlsx';
        $this->openFile($filePath, $list, $fileName);
    }

    public function openFile($filePath,  $dataApp, $fileName) {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('application', $dataApp);
        $tbs->download($fileName);
    }
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): CgSS
    {
        if (($model = CgSS::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Такой страницы не существует.');
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return Yii::$app->user->identity->jobEntrant();
    }
}
