<?php


namespace modules\entrant\models;


use yii\db\ActiveRecord;

class AnketaCiCg extends ActiveRecord
{
    public static function tableName()
    {
        return "{{%anketa_ci_cg}}";
    }
    public function rules()
    {
        return [
            [['id_anketa', 'competitive_group_id'], 'unique', 'targetAttribute'=>['id_anketa', 'competitive_group_id']],
        ];
    }

}