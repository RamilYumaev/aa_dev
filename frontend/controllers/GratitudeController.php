<?php
namespace frontend\controllers;

use teacher\helpers\TeacherClassUserHelper;
use teacher\helpers\UserTeacherJobHelper;
use teacher\models\TeacherClassUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class GratitudeController extends Controller
{
    public  $layout = 'print';
    /**
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */

    public function actionIndex($id) {

        $model= $this->findModel($id);
        $schoolId = UserTeacherJobHelper::columnSchoolId($model->user_id);
        $diploma = $model->getOlympicUserOne()->olympicUserDiploma();
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