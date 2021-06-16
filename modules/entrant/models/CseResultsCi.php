<?php

namespace modules\entrant\models;


use dictionary\models\DictDiscipline;
use yii\db\ActiveRecord;

class CseResultsCi extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%cse-results-ci}}';
    }

    public function rules()
    {
        return [
            ['anketa_id', 'exist', 'targetClass' => AnketaCi::class, 'targetAttribute' => ['anketa_id' => 'id']],
            ['cse_id', 'exist', 'targetClass' => DictDiscipline::class, 'targetAttribute' => ['cse_id' => 'id']],
            [['ball', 'year'], 'integer'],
        ];
    }

}