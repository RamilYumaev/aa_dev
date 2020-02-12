<?php
namespace common\moderation\helpers;

use common\auth\models\UserSchool;
use dictionary\models\DictSchools;
use olympic\models\auth\Profiles;
use yii\helpers\ArrayHelper;

class ModerationHelper
{
    const STATUS_NEW = 0;
    const STATUS_TAKE = 1;
    const STATUS_REJECT =2;


    public static function statusList() {
        return  [self::STATUS_NEW => "Новый",
                 self::STATUS_REJECT=> "Отклонен",
                 self::STATUS_TAKE => "Принят"];
    }


    public static function statusName ($key) {
        return ArrayHelper::getValue(self::statusList(), $key);
    }


    public static function modelList() {
        return  [
            UserSchool::class => "Учебные оргнаизации (Ученики/студенты)",
            DictSchools::class => "Учебные организации",
            Profiles::class=> "Профиль"];
    }

    public static function modelOneName ($key) {
        return ArrayHelper::getValue(self::modelList(), $key);
    }


}