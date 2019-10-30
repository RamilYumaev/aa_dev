<?php


namespace olympic\forms;


class AddFinalMarkForm extends Model
{
    public $mark;

    public function rules()
    {
        return [
            ['mark', 'required'],
            ['mark', 'integer', 'min' => 0, 'max' => 100],
        ];
    }

    public function attributeLabels()
    {
        return [
            'mark' => 'Оценка',
        ];
    }
}