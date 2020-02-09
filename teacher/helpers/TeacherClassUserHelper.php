<?php
namespace teacher\helpers;

use teacher\models\TeacherClassUser;
use yii\helpers\ArrayHelper;

class TeacherClassUserHelper
{

    const DRAFT = 0;
    const WAIT = 1;
    const ACTIVE = 2;

    public static function statusList(): array
    {
        return [
            self::DRAFT => 'Не подтверждено',
            self::WAIT=> 'Ожидание',
            self::ACTIVE => 'Подтверждено',
        ];
    }

    public static function  statusName($key): string
    {
        return ArrayHelper::getValue(self::statusList(), $key);
    }

    public static function find($id_olympic_user): ?TeacherClassUser
    {
        return TeacherClassUser::findOne(['user_id'=> \Yii::$app->user->identity->getId(),
            'id_olympic_user' => $id_olympic_user]);
    }


}