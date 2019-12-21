<?php

namespace operator\controllers\olympic;

use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use common\helpers\FileHelper;
use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use olympic\forms\OlympicCreateForm;
use olympic\forms\OlympicEditForm;
use olympic\forms\search\OlympicSearch;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicHelper;
use olympic\models\auth\Profiles;
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
use yii\web\User;

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
        $model = $this->getAllUserOlympic($olympic);
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        return $this->render('@backend/views/olympic/user-olympic/index', [
            'dataProvider' => $dataProvider,
            'olympic' => $olympic
        ]);
    }

    public function actionGetReportOlympic($olympicId)
    {
        $olympic = $this->findModel($olympicId);
        $neededUser = $this->getAllUserOlympic($olympic)->select("user_id")->column();
        $model = Profiles::find()->getAllMembers($neededUser, $olympic);
        $path = Yii::getAlias("@common") . DIRECTORY_SEPARATOR . "file_templates" . DIRECTORY_SEPARATOR . "members.docx";
        $fileName = "Список участников " . $olympic->genitive_name . " на " . date('Y-m-d H:i:s') . ".docx";

        FileHelper::getFile($model, $path, $fileName);

    }

    private function getAllUserOlympic(OlimpicList $olympic)
    {
        return UserOlimpiads::find()->where(['olympiads_id' => $olympic->id]);
    }


    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    protected function findModel($id): OlimpicList
    {
        if (($model = OlimpicList::find()->where(['id' => $id, 'olimpic_id' => OlympicHelper::olympicManagerList()])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


}