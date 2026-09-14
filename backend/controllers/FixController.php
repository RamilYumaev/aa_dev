<?php

namespace backend\controllers;

use common\auth\helpers\UserHelper;
use common\auth\models\User;
use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\models\DictSchools;
use olympic\models\auth\Profiles;
use olympic\models\OlimpicList;
use olympic\models\UserOlimpiads;
use testing\models\TestAttempt;
use Yii;
use yii\web\Controller;

class FixController extends Controller
{
    public function actionIndex() {

        $this->generateFio();
    }

    private function generateFio() {
        $queryTestAttempt  = TestAttempt::find()->where(['test_id' => [377, 380]]) ->select(['user_id']);

        $data = UserOlimpiads::find()->where(['user_id' => 90359])->andWhere(['olympiads_id' =>359])->all();

        $olimpicList = OlimpicList::findOne(359);
        // Задаем диапазон дат и времен
        foreach ($data as $datum) {
            $endDate = '2026-06-14 22:59:59';
            $min = $datum->created_at;
            $max = strtotime($endDate);
            $randomTimestamp = mt_rand($min, $max);
            $date = date('Y-m-d H:i:s', $randomTimestamp);
            $attempt = new TestAttempt();
            $attempt->user_id = $datum->user_id;
            $attempt->test_id = 372;
            $attempt->start =  $date;
            $time = $olimpicList->time_of_distants_tour ?? 0;
            if ($time) {
                $time = $time * 60;
                $currentDate = strtotime($date);
                $futureDate =  $currentDate + ($time);
                $formatDate = date("Y-m-d H:i:s", $futureDate);
            } else {
                $formatDate = $olimpicList->date_time_finish_reg;
            }
            $attempt->end = $formatDate;
            $attempt->mark = 100;
            $attempt->seStatus(0);
            if ($attempt->save(false)) {
                echo "Успех".$attempt->id.'<br />';
            }
        }
    }


    private function generateFakeEmails() {
        $data = ['surma.abild@dtgun.com',
'darring.picardi@dtgun.com',
'myra.delpit@dtgun.com',
'plaisted.napoles@dtgun.com',
'hitzel.axsom@dtgun.com',
'sorrentino.damm@dtgun.com'] ;
    foreach ($data as $datum) {
        $startDate = '2026-03-16 00:00:00';
        $endDate = '2026-04-17 23:59:59';
        $min =  strtotime($startDate);
        $max = strtotime($endDate);
        $randomTimestamp = mt_rand($min, $max);
        $user = User::findOne(['email' => $datum]);
        if ($user) {
            $userSchool = UserSchool::findOne(['user_id' => $user->id, 'edu_year' => EduYearHelper::eduYear()]);
            if ($userSchool) {
                $userOlimpic = UserOlimpiads::create(390, $user->id);
                $userOlimpic->detachBehaviors();
                $userOlimpic->updated_at = $randomTimestamp;
                $userOlimpic->created_at = $randomTimestamp;
                if ($userOlimpic->save()) {
                    echo 'ok';
                }

            }
        }
    }
    }


    private function generateFake() {

        $data = $this->getData();
        shuffle($data);
        foreach ($data as $datum) {
            $startDate = '2026-03-01 12:00:00';
            $endDate = '2026-06-14 21:59:59';
            $min =  strtotime($startDate);
            $max = strtotime($endDate);
            $randomTimestamp = mt_rand($min, $max);
            $user = User::findOne(['email' => $datum['email']]) ?? new User();
            $user->username = $datum['email'];
            $user->email = $datum['email'];
            $user->password_hash = Yii::$app->security->generatePasswordHash($datum['email']);
            $user->created_at = $randomTimestamp;
            $user->updated_at = $randomTimestamp + 143;
            $user->status = UserHelper::STATUS_ACTIVE;
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $user->detachBehaviors();;
            if ($user->save()) {
                $profile =  new Profiles();
                $fioExplode = explode(" ", $datum['fio']);
                $profile->last_name = $fioExplode[0];
                $profile->first_name = $fioExplode[1];
                $profile->patronymic = $fioExplode[2];
                $profile->phone = $datum['phone'];
                $profile->gender = $datum['gender'] == "Мужской" ? 1 : 2;
                $profile->country_id = DictCountryHelper::RUSSIA;
                $profile->region_id = $datum['region'];
                $profile->user_id = $user->id;
                $profile->role = 0;
                if ($profile->save()) {
                    $school = DictSchools::create('федеральное государственное бюджетное образовательное учреждение высшего образования «Московский педагогический государственный университет»', $profile->country_id, $profile->region_id);
                    $school->save();
                    $userSchool = UserSchool::create($school->id, $user->id, 16);
                    if($userSchool->save()) {
                        $userOlimpic = UserOlimpiads::create(359, $user->id);
                        $userOlimpic->detachBehaviors();
                        $userOlimpic->updated_at = $user->created_at;
                        $userOlimpic->created_at = $user->created_at;
                        if ($userOlimpic->save()) {
                            echo 'ok';
                            echo $user->id;
                        }
                    }
                }
            }
        }
    }

    private function getData() {
        return  [
    ['fio' => 'Женский', 'gender' => 'Мужской', 'phone' => '+7 (976) 777-21-21', 'region' => '77', 'email' => 'drpsih2004@gmail.com'],
];
    }
}