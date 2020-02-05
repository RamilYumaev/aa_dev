<?php


namespace teacher\models;

use teacher\helpers\UserTeacherJobHelper;
use teacher\models\queries\UserTeacherJobQuery;
use yii\db\ActiveRecord;

class UserTeacherJob extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */


    public static function tableName()
    {
        return 'user_teacher_job';
    }

    public static function create($school_id, $user_id)
    {
        $userTeacherJob = new static();
        $userTeacherJob ->user_id = $user_id;
        $userTeacherJob ->school_id = $school_id;
        $userTeacherJob ->status = UserTeacherJobHelper::DRAFT;
        return $userTeacherJob;
    }

    public function edit($school_id)
    {
        $this->school_id = $school_id;
        $this->status = UserTeacherJobHelper::DRAFT;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function isStatusWait()
    {
        return $this->status == UserTeacherJobHelper::WAIT;
    }

    public function isStatusActive()
    {
        return $this->status == UserTeacherJobHelper::ACTIVE;
    }

    public function isStatusDraft()
    {
        return $this->status == UserTeacherJobHelper::DRAFT;
    }

    public function generateVerificationToken()
    {
        $this->hash = \Yii::$app->security->generateRandomString() . '_' . time();
    }


    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'school_id' => 'Название учебной организации',
        ];
    }

    public static function find(): UserTeacherJobQuery
    {
        return new UserTeacherJobQuery(static::class);
    }

}