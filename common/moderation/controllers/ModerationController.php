<?php

namespace common\moderation\controllers;

use common\auth\models\UserSchool;
use common\moderation\forms\searches\ModerationSearch;
use common\moderation\helpers\ModerationHelper;
use common\moderation\models\Moderation;
use common\moderation\forms\ModerationMessageForm;
use common\moderation\services\ModerationService;
use dictionary\models\DictSchools;
use kartik\form\ActiveForm;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Address;
use modules\entrant\models\DocumentEducation;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PassportData;
use olympic\models\auth\Profiles;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

class ModerationController extends Controller
{
    private $service;

    public function __construct($id, $module, ModerationService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['moderation'],
                    ],
                ],
            ],

        ];
    }

    /**
     * Lists
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ModerationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/moderation/views/moderation/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $userId = $this->findUserId($id);
        return $this->render('@common/moderation/views/moderation/view', [
            'moderation' => $this->findModel($id),
            'userId' => $userId,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionReject($id)
    {
        $form = new ModerationMessageForm();
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->reject($id, $form);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->renderAjax('@common/moderation/views/moderation/reject', [
            'model' => $form,
        ]);
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function actionTake($id)
    {
        try {
            $this->service->take($id);
        } catch (\DomainException $e) {
            Yii::$app->errorHandler->logException($e);
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Moderation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Moderation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function findUserId($id)
    {
        $moderation = $this->findModel($id);

        switch ($moderation->model) {
            case AdditionalInformation::class :
                $model = AdditionalInformation::findOne($moderation->record_id);
                return $model->user_id ?? null;
                break;
            case UserSchool::class :
                $model = UserSchool::findOne($moderation->record_id);
                return $model->user_id ?? null;
                break;
            case OtherDocument::class :
                $model = OtherDocument::findOne($moderation->record_id);
                return $model->user_id ?? null;
                break;
            case Profiles::class :
                $model = Profiles::findOne($moderation->record_id);
                return $model->user_id ?? null;
                break;
            case PassportData::class :
                $model = PassportData::findOne($moderation->record_id);
                return $model->user_id ?? null;
                break;
            case Address::class :
                $model = Address::findOne($moderation->record_id);
                return $model->user_id ?? null;
            case DocumentEducation::class :
                $model = DocumentEducation::findOne($moderation->record_id);
                return $model->user_id ?? null;
            case DictSchools::class :
                return $moderation->created_by ?? null;
            default:
                return null;
        }
    }
}
