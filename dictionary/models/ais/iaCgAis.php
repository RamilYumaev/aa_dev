<?php


namespace dictionary\models\ais;


use yii\db\ActiveRecord;

class iaCgAis extends ActiveRecord
{
    public static function tableName()
    {
        return "individual_achievement_cg_ais";
    }
}