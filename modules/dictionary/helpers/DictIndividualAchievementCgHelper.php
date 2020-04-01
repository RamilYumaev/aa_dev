<?php


namespace modules\dictionary\helpers;


use modules\dictionary\models\DictIndividualAchievementCg;

class DictIndividualAchievementCgHelper
{
    public static function listCg($id) {
        return DictIndividualAchievementCg::find()->select('competitive_group_id')->individualAchievementId($id)->column();
    }

}