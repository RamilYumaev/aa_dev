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
            [['talon','phone','email'], 'unique']
        ];
    }

}