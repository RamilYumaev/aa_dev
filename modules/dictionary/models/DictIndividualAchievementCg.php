<?php


namespace modules\dictionary\models;

use modules\dictionary\models\queries\DictIndividualAchievementCgQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_individual_achievement_cg}}".
 *
 * @property integer $individual_achievement_id
 * @property integer $competitive_group_id
 **/

class DictIndividualAchievementCg extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%dict_individual_achievement_cg}}";
    }

    public static function create($individual_achievement_id, $competitive_group_id)
    {
        $dictIndividualAchievementCg = new static();
        $dictIndividualAchievementCg->individual_achievement_id =$individual_achievement_id;
        $dictIndividualAchievementCg->competitive_group_id = $competitive_group_id;

        return $dictIndividualAchievementCg;
    }


    public static function find(): DictIndividualAchievementCgQuery
    {
        return new DictIndividualAchievementCgQuery(static::class);
    }


}