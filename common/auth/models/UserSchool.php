<?php


namespace common\auth\models;

use common\helpers\EduYearHelper;
use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use dictionary\helpers\DictClassHelper;
use dictionary\helpers\DictSchoolsHelper;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class UserSchool extends YiiActiveRecordAndModeration
{
    /**
     * {@inheritdoc}
     */

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'moderation' => [
                'class' => ModerationBehavior::class,
                'attributes' => ['class_id', 'school_id'],
            ],
        ];
    }




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

    public function edit($school_id, $class_id)
    {
        $this->school_id = $school_id;
        $this->class_id = $class_id;
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

    public function titleModeration(): string
    {
        return  "Учебные оргнаизации (Ученики/студенты)". $this->edu_year;
    }

    public function moderationAttributes($value): array
    {
        return  [
            'school_id' => DictSchoolsHelper::schoolName($value),
            'class_id' => DictClassHelper::classFullName($value),];
    }
}