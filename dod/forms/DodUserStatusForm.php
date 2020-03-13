<?php
namespace dod\forms;

use dod\models\DateDod;
use dod\models\UserDod;
use yii\base\Model;

class DodUserStatusForm extends Model
{
    public $status_edu, $count;

    public function rules()
    {
        return [
            [['status_edu','count'], 'required'],
            [['status_edu'], 'integer'],
            [['count'], 'number', 'min'=> 1]
        ];
    }

    public function attributeLabels()
    {
        return (new UserDod())->attributeLabels();
    }
}