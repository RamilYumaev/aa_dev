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

    public function actionGetFile($id)
    {
        $model = $this->findModelUser($id);
        $filePath = $model->getUploadedFilePath('file_pd');
        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Запрошенный файл не найден.');
        }
        return Yii::$app->response->sendFile($filePath);
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
        $common[0]['block_speciality'] = key_exists('speciality', $data) ? 1:0;
        $common[0]['block_profile'] = key_exists('profile', $data) ? 1:0;
        $tbs->merge('common', $common);
        if(key_exists('regions', $data)) {
            $tbs->merge('regions', $data['regions']);
        }
        if(key_exists('subjects', $data)) {
            $tbs->merge('subjects', $data['subjects']);
        }
        if(key_exists('speciality', $data)) {
            $tbs->merge('speciality', $data['speciality']);
        }
        if(key_exists('profile', $data)) {
            $tbs->merge('profile', $data['profile']);
        }
        $tbs->download($fileName);
    }


    /**
     * @param $subject
     * @param $olympicId
     * @throws NotFoundHttpException
     */
    public function actionRound($subject, $olympicId, $ext = 'docx')
    {
        $olympic = $this->findModel($olympicId);
        $discipline = DictDiscipline::findOne($subject);
        if(!$discipline) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $data = $this->round($olympic, $discipline->id);
        $path = Yii::getAlias("@common") . DIRECTORY_SEPARATOR . "file_templates" . DIRECTORY_SEPARATOR . "qualif_round.".$ext;
        $fileName = "Ведомость отборочного этапа " . $olympic->genitive_name . " на " . date('Y-m-d H:i:s') . ".".$ext;
        $tbs = new TbsWrapper();
        $tbs->openTemplate($path);
        $common = [];
        $common[0]['year'] = str_replace( '-', '/', $olympic->year). ' уч. г.';
        $common[0]['subject'] = $discipline->name;
        $tbs->merge('common', $common);
        if(key_exists('members', $data)) {
            $tbs->merge('member', $data['members']);
        }
        $tbs->download($fileName);
    }

    /**
     * @param $olympicId
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionSubjects($olympicId)
    {
        $olympic = $this->findModel($olympicId);
        $data = $this->subjects($olympic);
        return $this->renderAjax('@backend/views/olympic/user-olympic/subjects',['data' => $data, 'olympicId' => $olympicId]);
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
        $specialites = [];
        $profiles = [];
        foreach ($model->all() as  $data) {
            $region =  DictSchoolsHelper::regionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year)) ??
                DictSchoolsHelper::preRegionName(UserSchoolHelper::userSchoolId($data->user_id, $olympic->year));
            if($region) {
                $regions[] = $region;
            }
            if($data->information) {
                $information = json_decode($data->information, true);
                $subjects[] = $disciplines[$information[0]];
                $subjects[] = $disciplines[$information[1]];
            }

            if($data->olympic_profile_id) {
                $specialites[] = $data->olympicProfile->olympicSpeciality->name;
                $profiles[] = $data->olympicProfile->name;
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

        $c = 0;
        asort($specialites);
        foreach (array_count_values($specialites) as $index => $speciality) {
            $array['speciality'][$c]['name'] = $index;
            $array['speciality'][$c]['count'] = $speciality;
            $c++;
        }

        $d = 0;
        asort($profiles);
        foreach (array_count_values($profiles) as $index => $profile) {
            $array['profile'][$d]['name'] = $index;
            $array['profile'][$d]['count'] = $profile;
            $d++;
        }
        return $array;
    }


    public function subjects($olympic) {
        $model = $this->getAllUserOlympic($olympic);
        $disciplines = DictDiscipline::find()->select('name')->indexBy('id')->column();
        /** @var UserOlimpiads $data */
        $subjects = [];
        foreach ($model->all() as  $data) {
            if($data->information) {
                $information = json_decode($data->information, true);
                $subjects[$information[0]] = $disciplines[$information[0]];
                $subjects[$information[1]] = $disciplines[$information[1]];
            }
        }
        return $subjects;
    }

    /**
     * @param $olympic
     * @param $subject
     * @return array
     * @throws NotFoundHttpException
     */
    protected function round($olympic, $subject) {

        $model = $this->getAllUserOlympic($olympic)->andWhere(['like', 'information', $subject]);
        /** @var UserOlimpiads $data */
        $members = [];
        foreach ($model->all() as $index => $data) {
            $members['members'][$index]['fio'] = ProfileHelper::profileFullName($data->user_id);
        }
        return $members;
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