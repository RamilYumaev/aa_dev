<?php


namespace modules\dictionary\models;

use modules\dictionary\models\queries\DictIndividualAchievementDocumentQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_individual_achievement_document}}".
 *
 * @property integer $individual_achievement_id
 * @property integer $document_type_id
 *
 **/

class DictIndividualAchievementDocument extends  ActiveRecord
{
    public static function tableName()
    {
        return "{{%dict_individual_achievement_document}}";
    }

    public static function create($individual_achievement_id, $document_type_id)
    {
        $dictIndividualAchievementDocument = new static();
        $dictIndividualAchievementDocument->individual_achievement_id =$individual_achievement_id;
        $dictIndividualAchievementDocument->document_type_id = $document_type_id;
        return $dictIndividualAchievementDocument;
    }


    public static function find(): DictIndividualAchievementDocumentQuery
    {
        return new DictIndividualAchievementDocumentQuery(static::class);
    }


}