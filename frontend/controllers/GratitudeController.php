<?php
namespace frontend\controllers;

use common\sending\helpers\SendingDeliveryStatusHelper;
use common\sending\models\SendingDeliveryStatus;
use common\sending\services\SendingDeliveryStatusService;
use olympic\models\Diploma;
use olympic\readRepositories\OlimpicReadRepository;
use teacher\helpers\TeacherClassUserHelper;
use teacher\helpers\UserTeacherJobHelper;
use teacher\models\TeacherClassUser;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;


class GratitudeController extends Controller
{
    public  $layout = 'print';

    private $service;

    public function __construct($id, $module,
                                SendingDeliveryStatusService $service, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     * @throws HttpException
     */
    public function actionIndex($id, $hash = null)
    {
        $model= $this->findModel($id);
        $schoolId = UserTeacherJobHelper::columnSchoolId($model->user_id);
        $diploma = $model->getOlympicUserOne()->olympicUserDiploma();
        if ($hash !== null) {
            $modelSendingDelivery =  SendingDeliveryStatus::find()
                ->hash($hash)
                ->type(SendingDeliveryStatusHelper::TYPE_OLYMPIC)
                ->typeSending(SendingDeliveryStatusHelper::TYPE_SEND_GRATITUDE)
                ->one();
            if (!$modelSendingDelivery) {
                throw new HttpException('404', 'Запрашиваемая страница не существует');
            }
            if (!$modelSendingDelivery->isStatusRead()) {
                try {
                    $this->service->statusRead($modelSendingDelivery->id);
                } catch (\DomainException $e) {
                    \Yii::$app->errorHandler->logException($e);
                    \Yii::$app->session->setFlash('error', $e->getMessage());
                }
            }
        }
        if($diploma && !is_null($schoolId)) {
            return $this->render('index', ['model' => $model, 'schoolId' => $schoolId, 'diploma' => $diploma]);
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    protected function findModel($id): TeacherClassUser
    {
        if (($model = TeacherClassUser::findOne(['id'=>$id,
                'status'=> TeacherClassUserHelper::ACTIVE])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Запрашиваемая страница не существует.');
    }

}