<?php
namespace dod\forms;

use dod\models\UserDod;
use yii\base\Model;

class DodUserTypeParticipationForm extends Model
{
    public $form_of_participation;

    public function rules()
    {
        return [
            [['form_of_participation'], 'required'],
            [['form_of_participation'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return (new UserDod())->attributeLabels();
    }


}