<?php


namespace modules\entrant\models;


use modules\dictionary\models\DictIndividualAchievement;
use yii\db\ActiveRecord;

class UserIndividualAchievements extends ActiveRecord
{
    public static function tableName()
    {
        return "{{user-individual-achievements}}";
    }

    public static function create($userId, $individualId, $documentId)
    {
        $model = new static();
        $model->user_id = $userId;
        $model->individual_id = $individualId;
        $model->document_id = $documentId;

        return $model;
    }

    public function getDictIndividualAchievement()
    {
        return $this->hasOne(DictIndividualAchievement::class, ["id" => "individual_id"]);
    }


}