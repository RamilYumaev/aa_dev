<?php


namespace modules\entrant\models;


use yii\db\ActiveRecord;

class UserIndividualAchievements extends ActiveRecord
{
    public static function tableName()
    {
        return "{{user-individual-achievements}}";
    }
}