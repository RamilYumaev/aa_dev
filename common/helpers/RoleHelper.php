<?php


namespace common\helpers;


use common\models\auth\AuthItem;
use yii\helpers\ArrayHelper;

class RoleHelper
{
    public static function roleList() {
        return  ArrayHelper::map(AuthItem::find()->all(), 'name', 'description');
    }

}