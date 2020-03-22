<?php

namespace modules\entrant\forms;

use yii\base\Model;

class CseSubjectMarkForm extends Model
{
    public $mark, $subject_id;

    /**
     * {@inheritdoc}
     */

    public function rules()
        {
        return [
            [[ 'mark', 'subject_id'], 'required'],
            [['subject_id'], 'integer'],
            [['mark'], 'integer', 'max' => 100],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ['mark' => "Балл", 'subject_id' => "Предмет ЕГЭ"];
    }

}