<?php

namespace operator\controllers\olympic;

use common\auth\helpers\UserSchoolHelper;
use common\components\TbsWrapper;
use common\helpers\FileHelper;
use common\sending\traits\MailTrait;
use dictionary\helpers\DictClassHelper;
use dictionary\helpers\DictSchoolsHelper;
use dictionary\models\DictDiscipline;
use olympic\forms\OlympicUserInformationForm;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\OlympicHelper;
use olympic\jobs\TestEmailJob;
use olympic\models\auth\Profiles;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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
        $model1 = clone $model;
        $dataProvider = new ActiveDataProvider(['query' => $model, 'pagination' => false]);
        $count = $model1->andWhere(['information' => null])->count();
        return $this->render('@backend/views/olympic/user-olympic/index', [
            'dataProvider' => $dataProvider,
            'olympic' => $olympic,
            'count' => $count
        ]);
    }

    /**
     * @param $id
     * @return array|string|Response
     * @throws NotFoundHttpException
     */

    public function actionUpdate($id) {
        $model = $this->findModelUser($id);
        $form = new OlympicUserInformationForm($model);
        if (Yii::$app->request->isAjax && $form->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($form);
        }
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $model->information = json_encode([$form->subject_one, $form->subject_two]);
            $model->save();
            return $this->redirect(['index', 'olympic_id' =>  $model->olympiads_id]);
        }

        return $this->renderAjax('@backend/views/olympic/user-olympic/_form', [
            'model' => $form
        ]);

    }
    /**
     * @param $olympicId
     * @throws NotFoundHttpException
     */
    public function actionGetReportOlympic($olympicId, $ext = 'docx')
    {
        $olympic = $this->findModel($olympicId);
        $model = $this->data($olympic);
        $path = Yii::getAlias("@common") . DIRECTORY_SEPARATOR . "file_templates" . DIRECTORY_SEPARATOR . "members.".$ext;
        $fileName = "Список участников " . $olympic->genitive_name . " на " . date('Y-m-d H:i:s') . ".".$ext;

        FileHelper::getFile($model, $path, $fileName);
    }


    /**
     * @param $olympicId
     * @throws NotFoundHttpException
     */
    public function actionGetStatistic($olympicId, $ext = 'docx')
    {
        $olympic = $this->findModel($olympicId);
        $data = $this->statistic($olympic);
        $path = Yii::getAlias("@common") . DIRECTORY_SEPARATOR . "file_templates" . DIRECTORY_SEPARATOR . "statistic.".$ext;
        $fileName = "Статистика " . $olympic->genitive_name . " на " . date('Y-m-d H:i:s') . ".".$ext;
        $tbs = new TbsWrapper();
        $tbs->openTemplate($path);
        $common = [];
        $common[0]['block_subject'] = key_exists('subjects', $data) ? 1:0;
        $tbs->merge('common', $common);
        if(key_exists('subjects', $data)) {
            $tbs->merge('regions', $data['regions']);
        }
        if(key_exists('subjects', $data)) {
            $tbs->merge('subjects', $data['subjects']);
        }
        $tbs->download($fileName);
    }

    /***
     * @param $id
     * @return
     * @throws NotFoundHttpException
     */
    public function actionSendSubject($id) {
        $olympic = $this->findModel($id);
        if($olympic->olimpic_id == 61) {
            \Yii::$app->queue->push(new TestEmailJob(['olympicId' => $olympic->id]));
        }
        Yii::$app->session->setFlash('success', "Всем участником отправлены письма");
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function data($olympic) {
        $model = $this->getAllUserOlympic($olympic);
        $disciplines = DictDiscipline::find()->select('name')->indexBy('id')->column();
        /** @var UserOlimpiads $data */
        $array = [];
        foreach ($model->all() as  $index => $data) {
            $array[$index]['fio'] = ProfileHelper::profileFullName($data->user_id);
            $array[$index]['phone'] = ProfileHelper::findProfile($data->user_id)->phone ?? "";
            $array[$index]['email'] = \common\auth\helpers\UserHelper::getEmailUserId($data->user_id);
            $array[$index]['school'] =  DictSchoolsHelper::schoolName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year)) ??
                DictSchoolsHelper::preSchoolName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year));
            $array[$index]['class'] = DictClassHelper::classFullName(UserSchoolHelper::userClassId($data->user_id, $olympic->year));
            $array[$index]['region'] =  DictSchoolsHelper::regionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year)) ??
                DictSchoolsHelper::preRegionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year));
            $array[$index]['date'] = $data->created_at ? Yii::$app->formatter->asDate($data->created_at,'php:d.m.Y') :  "";
            if($data->information) {
                $information = json_decode($data->information, true);
                $array[$index]['subject_1'] = $disciplines[$information[0]];
                $array[$index]['subject_2'] = $disciplines[$information[1]];
            } else {
                $array[$index]['subject_1'] = '';
                $array[$index]['subject_2'] = '';
            }

        }
        return $array;
    }

    public function statistic($olympic) {
        $model = $this->getAllUserOlympic($olympic);
        $disciplines = DictDiscipline::find()->select('name')->indexBy('id')->column();
        /** @var UserOlimpiads $data */
        $regions = [];
        $array = [];
        $subjects = [];
        foreach ($model->all() as  $data) {
            $regions[] =  DictSchoolsHelper::regionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year)) ??
                DictSchoolsHelper::preRegionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year));
            if($data->information) {
                $information = json_decode($data->information, true);
                $subjects[] = $disciplines[$information[0]];
                $subjects[] = $disciplines[$information[1]];
            }
        }
        $a  = 0;
        asort($regions);
        foreach (array_count_values($regions) as $index => $region) {
            $array['regions'][$a]['name'] = $index;
            $array['regions'][$a]['count'] = $region;
            $a++;
        }
        $b  = 0;
        asort($subjects);
        foreach (array_count_values($subjects) as $index => $subject) {
            $array['subjects'][$b]['name'] = $index;
            $array['subjects'][$b]['count'] = $subject;
            $b++;
        }
        return $array;
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
    protected function findModelUser($id): UserOlimpiads
    {
        if (($model = UserOlimpiads::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
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