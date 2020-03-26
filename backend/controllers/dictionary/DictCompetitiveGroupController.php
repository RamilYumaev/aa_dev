<?php


namespace backend\controllers\dictionary;

use backend\models\AisCg;
use dictionary\forms\DictCompetitiveGroupCreateForm;
use dictionary\forms\DictCompetitiveGroupEditForm;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\DictSpeciality;
use dictionary\models\DictSpecialization;
use dictionary\models\Faculty;
use dictionary\services\DictCompetitiveGroupService;
use Yii;
use dictionary\forms\search\DictCompetitiveGroupSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DictCompetitiveGroupController extends Controller
{
    private $service;

    public function __construct($id, $module, DictCompetitiveGroupService $service, $config = [])
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
        $searchModel = new DictCompetitiveGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'competitiveGroup' => $this->findModel($id),
        ]);
    }

    /**
     * @return mixed
     */
    public function actionCreate()
    {
        $form = new DictCompetitiveGroupCreateForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $model = $this->service->create($form);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
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
        $model = $this->findModel($id);

        $form = new DictCompetitiveGroupEditForm($model);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->edit($model->id, $form);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'model' => $form,
            'competitiveGroup' => $model,
        ]);
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
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        try {
            $this->service->remove($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionGetCg($levelId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['result' => $this->service->getAllCg($levelId)];
    }


//    public function actionGetAisCg($year)
//    {
//        /**
//         * @var $allCg AisCg
//         */
//        $allCg = AisCg::find()->andWhere(['year' => $year])->all();
//
//        foreach ($allCg as $aisCg) {
//            $sdoCg = DictCompetitiveGroup::findCg(
//                $aisCg->faculty_id,
//                $aisCg->speciality_id,
//                $aisCg->specialization_id, $aisCg->education_form_id, $aisCg->financing_type_id, $aisCg->year);
//
//            if ($sdoCg->exists()) {
//                $model = $sdoCg->one();
//                $form2 = new DictCompetitiveGroupCreateForm($model);
//                $refreshRecord = DictCompetitiveGroup::create($form2, $model->faculty_id, $model->speciality_id,
//                    $model->specialization_id);
//                $form = new DictCompetitiveGroupEditForm($refreshRecord);
//
//                $this->service->edit($model->id, $form);
//
//            } else {
//                $form3 = new DictCompetitiveGroupCreateForm($aisCg);
//                $newRecord = DictCompetitiveGroup::create($form3,
//                    Faculty::aisToSdoConverter($aisCg->faculty_id),
//                    DictSpeciality::aisToSdoConverter($aisCg->speciality_id),
//                    DictSpecialization::aisToSdoConverter($aisCg->specialization_id));
//
//                $form = new DictCompetitiveGroupCreateForm($newRecord);
//
//                $this->service->create($form);
//            }
//        }
//        return "success";
//    }

}