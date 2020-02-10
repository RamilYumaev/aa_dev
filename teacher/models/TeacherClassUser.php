<?php

namespace teacher\models;

use olympic\models\UserOlimpiads;
use teacher\helpers\UserTeacherJobHelper;
use yii\db\ActiveRecord;

class TeacherClassUser extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    private $_olympicUser;

    public static function tableName()
    {
        return 'teacher_user_class';
    }

    public function __construct($config = [])
    {
        $this->_olympicUser = new UserOlimpiads();
        parent::__construct($config);
    }

    public static function create($id_olympic_user)
    {
        $userTeacherJob = new static();
        $userTeacherJob ->user_id = \Yii::$app->user->identity->getId();
        $userTeacherJob ->id_olympic_user = $id_olympic_user;
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

    public function generateVerificationToken()
    {
        $this->hash = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @return  UserOlimpiads
     */
    public function getOlympicUserOne() {
        return $this->_olympicUser->olympicUserRelation($this->id_olympic_user)->one();
    }


    /**
     * {@inheritdoc}
     */

    public function attributeLabels()
    {
        return [
            'id_olympic_user' => 'ФИО Ученика',
        ];
    }


}