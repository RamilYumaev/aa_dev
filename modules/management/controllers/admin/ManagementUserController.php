<?php
namespace modules\management\controllers\admin;

use modules\entrant\helpers\PdfHelper;
use modules\management\forms\ScheduleForm;
use modules\management\models\ManagementUser;
use modules\management\models\Schedule;
use modules\management\searches\ScheduleSearch;
use modules\management\services\ScheduleService;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use yii\web\NotFoundHttpException;

class ManagementUserController extends Controller
{
    /**
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionAssistant($userId, $postRateId, $assistant)
    {
        $model = ManagementUser::findOne(['user_id' => $userId, 'post_rate_id' => $postRateId]);
        if(!$model){
            throw new NotFoundHttpException('Такой информации не существвует.');
        }
        $model->setIsAssistant($assistant);
        $model->save();
        return $this->redirect(Yii::$app->request->referrer);
    }

}