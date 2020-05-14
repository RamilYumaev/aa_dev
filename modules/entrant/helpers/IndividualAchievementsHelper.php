<?php


namespace modules\entrant\helpers;


use modules\entrant\models\UserIndividualAchievements;
use yii\helpers\Html;

class IndividualAchievementsHelper
{
    public static function htmlButton($individualId, $userId)
    {
        $alreadyRecorded = UserIndividualAchievements::find()->alreadyRecorded($individualId, $userId)->exists();

        $save = Html::a(Html::tag("span", "",
            ["class" => "glyphicon glyphicon-plus"]),
            ["save", "id" => $individualId],
            ["class" => "btn btn-success",
                'data-pjax' => 'w0', 'data-toggle' => 'modal',
                'data-target' => '#modal', 'data-modalTitle' => 'Добавить']);

        $remove = Html::a(Html::tag("span","", ["class" => "glyphicon glyphicon-minus"]), ["remove",
            "id" => $individualId], ["class"=> "btn btn-danger"]);

        return $alreadyRecorded ? $remove : $save;
    }

    public static function isExits($user, $eduLevel)
    {
        return UserIndividualAchievements::find()->cgUserEduLevelExits($user, $eduLevel);
    }

    public static function all($user, $eduLevel)
    {
        return UserIndividualAchievements::find()->cgUserEduLevelAll($user, $eduLevel);
    }

    public static function column($user, $eduLevel)
    {
        return UserIndividualAchievements::find()->cgUserEduLevelColumn($user, $eduLevel);
    }



}