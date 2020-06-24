<?php


namespace modules\entrant\components;


use yii\validators\Validator;

class MaxDateValidate extends Validator
{
    public function validateAttribute($model, $attribute)
    {
        if (strtotime($model->$attribute) > strtotime(\date("Y-m-d"))) {
            $this->addError($model, $attribute, "Указанная дата больше чем текущая" );
            return false;
        }
        return true;
    }
}