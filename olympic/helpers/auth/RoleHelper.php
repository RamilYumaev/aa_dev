<?php


namespace olympic\helpers\auth;


use olympic\models\auth\AuthItem;
use yii\helpers\ArrayHelper;

class RoleHelper
{
    const ROLE_USER = 'user';
    const ROLE_ADMIN = 'admin';

    public static function roleList() {
        return  ArrayHelper::map(AuthItem::find()->all(), 'name', 'description');
    }

}