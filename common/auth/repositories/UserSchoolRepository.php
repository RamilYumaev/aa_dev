<?php

namespace common\auth\repositories;

use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;
use yii\helpers\Html;

class UserSchoolRepository
{
    public function isSchooLUser($user_id): void
    {
        if ($model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => EduYearHelper::eduYear()])) {
            throw new \DomainException('Вы не можете добаить класс или  учебную организацию, так как есть запись 
            на '.EduYearHelper::eduYear(). ' уч. год!');
        }
    }

    public function getUserCurrentYear($user_id) {
        return $model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => EduYearHelper::eduYear()]);
    }

    public function get($id, $user_id): UserSchool
    {
        if (!$user =  UserSchool::findOne(['user_id' => $user_id, 'id'=> $id])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }


    public function getSchoolUserId($school_id, $user_id): UserSchool
    {
        if (!$user =  UserSchool::findOne(['user_id' => $user_id, 'school_id'=> $school_id])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }


    public function getSchooLUser($user_id): UserSchool
    {
        if (!$model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => EduYearHelper::eduYear()])) {
            throw new \DomainException('Для записи на олимпиаду необходимо актуализировать информацию в разделе 
            '.Html::a('"Ваша учебная организация"', '/schools').' на '.EduYearHelper::eduYear(). ' уч. год!');
        }
        return $model;
    }

    public function isSchool($school_id): bool
    {
        return UserSchool::find()->where(['school_id' =>$school_id ])->exists();
    }


    public function save(UserSchool $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(UserSchool $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}