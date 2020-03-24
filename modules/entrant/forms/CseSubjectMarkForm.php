<?php

namespace modules\entrant\forms;

use modules\dictionary\helpers\DictCseSubjectHelper;
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
            ['mark', 'validateMinCseSubject'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ['mark' => "Балл", 'subject_id' => "Предмет ЕГЭ"];
    }

    public function validateMinCseSubject($attribute, $params)
    {
        $min = DictCseSubjectHelper::valueMark($this->subject_id);
        $max = DictCseSubjectHelper::MAX;
        if ($this->mark < $min || $this->mark > $max) {
            $this->addError('mark', DictCseSubjectHelper::name($this->subject_id). " от ".$min. " до ". $max);
            return false;
        }
        return true;
    }

}