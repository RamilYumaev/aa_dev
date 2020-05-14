<?php


namespace modules\dictionary\helpers;
use modules\dictionary\models\DictIndividualAchievement;

class DictIndividualAchievementHelper
{
    public static function dictIndividualAchievementUser($userId) {

        $selectIndividualAchievement = DictIndividualAchievementCgHelper::dictIndividualAchievementCgUserColumn($userId);
        return DictIndividualAchievement::find()
            ->andWhere(["in", "id", $selectIndividualAchievement])
            ->all();
    }
}