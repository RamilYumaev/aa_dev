<?php

namespace modules\entrant\models;


use common\auth\models\User;
use yii\db\ActiveRecord;

class AnketaCi extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%anketa_ci}}';
    }

    public function rules()
    {
        return [
            [['lastName', 'firstName', 'patronymic', ], 'string'],
            ['operator_id', 'exist', 'targetClass'=>User::class, 'targetAttribute'=>['operator_id'=>'id']],
            [['phone','email'], 'unique']
        ];
    }

    public function getFio() {
        return $this->lastName." ".$this->firstName.' '.$this->patronymic;
    }

    public function getAnketaCg() {
        return $this->hasMany(AnketaCiCg::class,['id_anketa' => 'id']);
    }

}