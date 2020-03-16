<?php


namespace dod\models;


use dod\helpers\UserDodHelper;

class UserDod extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_dod';
    }

    public static function create($dod_id,
                                  $user_id,
                                  $form_of_participation = null,
                                  $status_edu= null,
                                  $school_id = null,
                                  $count=null)
    {
        $userDod = new static();
        $userDod->dod_id = $dod_id;
        $userDod->user_id = $user_id;
        $userDod->form_of_participation = $form_of_participation;
        $userDod->status_edu = $status_edu;
        $userDod->school_id = $school_id;
        $userDod->count = $count;

        return $userDod;
    }

    public function isFormLive() {
        return $this->form_of_participation == UserDodHelper::FORM_LIVE_BROADCAST;
    }

    public function attributeLabels()
    {
        return [
            'count'=>'Количество участников',
            'status_edu' => "Статус участника",
            'school_id' => "Учебная оргнаизация",
            'form_of_participation' => "Форма участия"
        ];
    }
}