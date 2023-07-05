<?php

namespace common\moderation\controllers;

use common\auth\models\UserSchool;
use common\moderation\forms\searches\ModerationSearch;
use common\moderation\helpers\DataExportHelper;
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
                    'update-export-data' => ['POST'],
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

    /**
     * @param $id
     * @param null $did
     * @return Response
     * @throws NotFoundHttpException
     */

    public function actionUpdateExportData($id=null, $did = null, $user=null)
    {
        if($id) {
            $model = $this->findModel($id);
            $data = Json::encode(DataExportHelper::dataDocumentOne($model, $did));
        }else {
            $data = Json::encode(DataExportHelper::dataEduction($did, $user));
        }

        $token = Yii::$app->user->identity->getAisToken();
        if (!$token) {
            Yii::$app->session->setFlash("error", "У вас отсутствует токен. 
                Чтобы получить, необходимо в вести логин и пароль АИС");
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            $ch = curl_init();
            if(!$data) {
                Yii::$app->session->setFlash("error", "Нет данных для передачи в АИС ВУЗ");
                return $this->redirect(Yii::$app->request->referrer);
            }
            $headers = array("Content-Type" => "multipart/form-data");
            curl_setopt($ch, CURLOPT_URL, \Yii::$app->params['ais_server'] . '/import-entrant-update-doc?access-token=' . $token);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
            if ($status_code !== 200) {
                Yii::$app->session->setFlash("error", "Ошибка! $result");
                return $this->redirect(Yii::$app->request->referrer);
            }
            curl_close($ch);

            $result = Json::decode($result);

            if (array_key_exists('status', $result)) {
                if($id) {
                    $this->service->take($id); return $this->redirect(['index']);
                }
                Yii::$app->session->setFlash('success', "Данные успешно обновлены");
            } else if (array_key_exists('message', $result)) {
                Yii::$app->session->setFlash('warning', $result['message']);
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @param null $did
     * @param null $user
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionJson($id=null, $did = null, $user=null) {
        if($id) {
            $model = $this->findModel($id);
            return Json::encode(DataExportHelper::dataDocumentOne($model, $did));
        }
        return Json::encode(DataExportHelper::dataEduction($did, $user));
    }
}
