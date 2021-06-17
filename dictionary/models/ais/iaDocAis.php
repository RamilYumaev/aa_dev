<?php


namespace dictionary\models\ais;


use yii\db\ActiveRecord;

class iaDocAis extends ActiveRecord
{
    public static function tableName()
    {
        return "dict_individual_achievement_document_ais";
    }
}