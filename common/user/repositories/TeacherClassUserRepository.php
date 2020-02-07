<?php

namespace common\user\repositories;
use teacher\models\TeacherClassUser;

class TeacherClassUserRepository
{
    public function isUserClassTeacher($user_id, $id_olympic_user): void
    {
        if ($model = TeacherClassUser::findOne(['user_id' => $user_id, 'id_olympic_user' =>$id_olympic_user ])) {
            throw new \DomainException('Такая запись существует');
        }
    }

    public function getFull($id, $user_id,  $id_olympic_user):  TeacherClassUser
    {
        if (!$user =  TeacherClassUser::findOne(['user_id' => $user_id, 'id'=> $id,  'id_olympic_user' => $id_olympic_user])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }

    public function get($id):  TeacherClassUser
    {
        if (!$user =  TeacherClassUser::findOne($id)) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }


    public function getHash($hash): TeacherClassUser
    {
        if (!$user =  TeacherClassUser::findOne(['hash' => $hash])) {
            throw new \DomainException('Такой записи нет.');
        }
        return $user;
    }

    public function save(TeacherClassUser $model): void
    {
        if (!$model->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(TeacherClassUser $model): void
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}