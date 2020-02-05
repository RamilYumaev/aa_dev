<?php
namespace common\moderation\helpers;

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
        return  [\dictionary\models\DictSchools::class => "Учебные организации",
            \dictionary\models\DictClass::class => "Классы"];
    }

    public static function modelOneName ($key) {
        return ArrayHelper::getValue(self::modelList(), $key);
    }


}