<?php


namespace modules\dictionary\helpers;


use modules\dictionary\models\DictIndividualAchievementCg;
use modules\entrant\helpers\UserCgHelper;

class DictIndividualAchievementCgHelper
{
    public static function listCg($id) {
        return DictIndividualAchievementCg::find()->select('competitive_group_id')->individualAchievementId($id)->column();
    }

    public static function dictIndividualAchievementCgUserColumn($userId)
    {
        $userChoiceCg = UserCgHelper::cgUserColumn($userId);
       return  DictIndividualAchievementCg::find()->andWhere(['in', 'competitive_group_id', $userChoiceCg])->column();
    }

}