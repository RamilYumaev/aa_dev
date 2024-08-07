<?php
namespace modules\entrant\modules\ones_2024\controllers\admin;

use common\components\TbsWrapper;
use modules\dictionary\jobs\CompetitionListJob;
use modules\entrant\modules\ones_2024\job\FinalHandler;
use modules\entrant\modules\ones_2024\forms\search\CgSSSearch;
use modules\entrant\modules\ones_2024\forms\search\EntrantAppSearch;
use modules\entrant\modules\ones_2024\job\CompetitionListEpkJob;
use modules\entrant\modules\ones_2024\job\CompetitiveListJob;
use modules\entrant\modules\ones_2024\job\CreateBigFileJob;
use modules\entrant\modules\ones_2024\model\CgSS;
use modules\entrant\modules\ones_2024\model\CompetitiveList;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
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

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CgSSSearch();
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
            return $this->redirect('index');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @param null $different
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id, $different = null)
    {
        $model = $this->findModel($id);
        $searchModel = new EntrantAppSearch($model->quid, null, $different);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetAll()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        /**
         * @var $item CgSS
         */
        foreach (CgSS::find()->all() as $item) {
            if($item->url) {
                $queue->push(new CompetitionListEpkJob(['model'=>$item]));
            }
        }
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionGetListEpk($id)
    {
        $model = $this->findModel($id);
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new CompetitionListEpkJob(['model'=>$model]));

        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionDataCompetitive($id)
    {
        $model = $this->findModel($id);
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new CompetitiveListJob(['model'=>$model]));

        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }


    public function actionDataAllCompetitive()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        /**
         * @var $item CgSS
         */
        foreach (CgSS::find()->andWhere(['type' => 'Основные места в рамках КЦП'])->all() as $item) {
            $queue->push(new CompetitiveListJob(['model' => $item]));
        }

        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionTableFile($id, $competitive = null)
    {
        $model = $this->findModel($id);
        $list = $competitive == 1 ? $model->getListForCompetitive() : $model->getList();
        $fileName = $model->name.".xlsx";
        $filePath =  \Yii::getAlias('@common').'/file_templates/list_ss.xlsx';
        $this->openFile($filePath, $list, $fileName);
    }


    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionTableCompetitive($id)
    {
        $model = $this->findModel($id);
        $list = [];
        /** @var CompetitiveList $item */
        foreach ($model->getCompetitiveList()->all() as $key => $item) {
            $list[$key]['number'] = $item->number;
            $list[$key]['fio'] = $item->fio;
            $list[$key]['snils_or_id'] = $item->snils_or_id;
            $list[$key]['exam_1'] = $item->ball_exam_1;
            $list[$key]['exam_2'] = $item->ball_exam_2;
            $list[$key]['exam_3'] = $item->ball_exam_3;
            $list[$key]['exam_name_1'] = $item->exam_1;
            $list[$key]['exam_name_2'] = $item->exam_2;
            $list[$key]['exam_name_3'] = $item->exam_3;
            $list[$key]['sum_individual'] = $item->mark_ai;
            $list[$key]['sum_ball'] = $item->sum_ball;

            $list[$key]['status'] = $item::isOnOtherSuccess($item->snils_or_id, $item->id) ? "Прошел по другому конкурсу" :$item->getStatusName();
            $list[$key]['priority'] = $item->priority;
        }
        $fileName = "Результат конурса". $model->name.".xlsx";
        $filePath =  \Yii::getAlias('@common').'/file_templates/list_result.xlsx';
        $this->openFile($filePath, $list, $fileName);
    }

    /**
     * @param $id
     * @throws NotFoundHttpException
     */
    public function actionTableList($id, $fok = null)
    {
        $model = $this->findModel($id);
        $list = $fok == 1 ? $model->getListFok() : $model->getList();

        $list = array_map(function ($v) use ($model) {
            $v['quid_cg'] = $model->quid;
            $entrant = EntrantSS::findOne(['quid' => $v['quid_profile']]);
            if ($entrant) {
                $v['snils'] = str_replace([' ', '-'], '', $entrant->snils);
            }

            if($v['name_exams']) {
                $data =  explode(')', $v['name_exams']);
                foreach ($data as $key => $exam) {
                    if($exam == '') {
                        continue;
                    }
                    $v['name_exam_'.($key+1)] = $exam.')';
                }
            }
            return $v;
        }, $list);

        $list = array_filter($list, function ($v) {
            return !empty($v['number']);
        });

        $fileName = "Конкурсный список " .$model->name.".xlsx";
        $filePath =  \Yii::getAlias('@common').'/file_templates/list_ss_1.xlsx';
        $this->openFile($filePath, $list, $fileName);
    }

    public function openFile($filePath,  $dataApp, $fileName) {
        $tbs = new TbsWrapper();
        $tbs->openTemplate($filePath);
        $tbs->merge('application', $dataApp);
        $tbs->download($fileName);
    }

    public function actionAllList()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $message = 'Задание отправлено в очередь';
        $queue->push(new CreateBigFileJob());

        Yii::$app->session->setFlash("info", $message);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionGetAllList()
    {
        $fileName = "all-list.xlsx";

        $file = \Yii::getAlias('@modules').'/entrant/files/ss/'.$fileName;

        if(file_exists($file)) {
            return Yii::$app->response->sendFile($file);
        }
    }

    public function actionFinalHandle()
    {
        $queue = Yii::$app->queue;
        $queue->ttr(20000);
        $queue->push(new FinalHandler());
        $message = 'Задание "Провести конкурс (альтернатива)" отправлено в очередь';
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
    }

    public function actionClear($level){
        $cgs = CgSS::find()->andWhere(['education_level'=>$level])->select('id')->column();
        $message = 'Не найдены кг.';
        if($cgs) {
            CgSS::updateAll(['status'=> CgSS::STATUS_NEW], ['id' => $cgs]);
            CompetitiveList::updateAll(['status'=> CompetitiveList::STATUS_NEW], ['cg_id'=> $cgs]);
            $message = 'Конкурс обнулен. '.$level;
        }
        Yii::$app->session->setFlash("info", $message);
        return  $this->redirect('index');
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
}
