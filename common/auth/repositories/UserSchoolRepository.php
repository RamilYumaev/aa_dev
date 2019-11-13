<?php

namespace common\auth\repositories;

use common\auth\models\UserSchool;
use common\helpers\EduYearHelper;

class UserSchoolRepository
{
    public function isSchooLUser($user_id): void
    {
        if ($model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => EduYearHelper::eduYear()])) {
            throw new \DomainException('Вы не можете добаить класс или  учебную организацию, так как есть запись 
            на '.EduYearHelper::eduYear(). ' уч. год!');
        }
    }

    public function getSchooLUser($user_id): UserSchool
    {
        if (!$model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => EduYearHelper::eduYear()])) {
            throw new \DomainException('У вас нет записи учебной организации на '.EduYearHelper::eduYear(). ' уч. год!');
        }
        return $model;
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