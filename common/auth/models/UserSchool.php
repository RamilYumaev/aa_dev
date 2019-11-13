<?php


namespace common\auth\models;

use common\helpers\EduYearHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class UserSchool extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'user_school';
    }

    public static function create($school_id, $user_id, $class_id)
    {
        $userSchool = new static();
        $userSchool ->user_id = $user_id;
        $userSchool ->school_id = $school_id;
        $userSchool ->class_id = $class_id;
        $userSchool->edu_year = EduYearHelper::eduYear();

        return $userSchool;
    }

    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'school_id' => 'Название учебной организации',
            'class_id' => 'Текущий класс (курс)',
            'edu_year' => "Учебный год"
        ];
    }

}