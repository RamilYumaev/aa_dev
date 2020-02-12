<?php

namespace common\user\repositories;
use teacher\models\UserTeacherJob;

class UserTeacherSchoolRepository
{
    public function isSchoolTeacher($user_id, $school_id): void
    {
        if ($model = UserTeacherJob::findOne(['user_id' => $user_id, 'school_id' =>$school_id ])) {
            throw new \DomainException('Такая запись существует');
        }
    }

    public function isSchool($school_id): bool
    {
        return UserTeacherJob::find()->where(['school_id' =>$school_id ])->exists();
    }


    public function get($id, $user_id): UserTeacherJob
    {
        if (!$user =  UserTeacherJob::findOne(['user_id' => $user_id, 'id'=> $id])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }

    public function getHash($hash): UserTeacherJob
    {
        if (!$user =  UserTeacherJob::findOne(['hash' => $hash])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }


    public function save(UserTeacherJob $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(UserTeacherJob $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}