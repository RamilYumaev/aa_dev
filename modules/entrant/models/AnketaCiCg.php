<?php


namespace modules\entrant\models;


use dictionary\models\DictCompetitiveGroup;
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

    public function getCg() {
        return $this->hasOne(DictCompetitiveGroup::class, ['id'=>'competitive_group_id']);
    }

}