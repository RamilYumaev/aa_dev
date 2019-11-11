<?php

namespace common\auth\repositories;

use common\auth\models\UserSchool;
use common\helpers\UserSchoolHelper;

class UserSchoolRepository
{
    public function isSchooLUser($user_id): void
    {
        if ($model = UserSchool::findOne(['user_id' => $user_id, 'edu_year' => UserSchoolHelper::eduYear()])) {
            throw new \DomainException('Вы не можете добаить класс или  учебную организацию, так как есть запись 
            на '.UserSchoolHelper::eduYear(). ' уч. год!');
        }
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