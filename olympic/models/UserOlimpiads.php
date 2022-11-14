<?php


namespace olympic\models;


use common\auth\helpers\UserSchoolHelper;
use common\auth\models\User;
use dictionary\helpers\DictClassHelper;
use dictionary\helpers\DictSchoolsHelper;
use olympic\helpers\auth\ProfileHelper;
use olympic\helpers\DiplomaHelper;
use olympic\helpers\OlympicListHelper;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

class UserOlimpiads extends \yii\db\ActiveRecord
{
    private $_olimpicList;

    const DRAFT = 0;
    const WAIT = 1;
    const ACTIVE = 2;

    public static function statusList(): array
    {
        return [
            self::DRAFT => 'Не подтверждено',
            self::WAIT=> 'Ожидание',
            self::ACTIVE => 'Подтверждено',
        ];
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }

    public static function statusName($key): string
    {
        return ArrayHelper::getValue(self::statusList(), $key);
    }

    public function __construct($config = [])
    {
        $this->_olimpicList = new OlimpicList();
        parent::__construct($config);
    }

    public static function create($olympiads_id, $user_id)
    {
        $olimpicUser = new static();
        $olimpicUser->olympiads_id = $olympiads_id;
        $olimpicUser->user_id = $user_id;

        return $olimpicUser;
    }

    public function setStatus($status) {
        $this->status  = $status;
    }

    public function setTeacher($teacher_id) {
        $this->teacher_id  = $teacher_id;
    }

    public function setReset() {
        $this->teacher_id  = null;
        $this->hash = null;
        $this->status = self::DRAFT;
    }

    public function isStatusWait()
    {
        return $this->status == self::WAIT;
    }

    public function isStatusActive()
    {
        return $this->status == self::ACTIVE;
    }

    public function isStatusDraft()
    {
        return $this->status == self::DRAFT;
    }

    public function generateVerificationToken()
    {
        $this->hash = \Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function getOlympicOne() {
        return $this->_olimpicList->olympicListRelation($this->olympiads_id)->one();
    }

    public function getOlympicAndYear() {
        return OlympicListHelper::olympicAndYearName($this->olympiads_id);
    }

    public function  getSchoolUser() {
        return DictSchoolsHelper::schoolName(UserSchoolHelper::userSchoolId($this->user_id, $this->olympicOne->year)) ??
        DictSchoolsHelper::preSchoolName(UserSchoolHelper::userSchoolId($this->user_id, $this->olympicOne->year));
    }

    public function  getClassUser() {
        return DictClassHelper::classFullName(UserSchoolHelper::userClassId($this->user_id, $this->olympicOne->year));
    }

    public function  getFullNameUserOrTeacher($user_id) {
        return ProfileHelper::profileFullName($user_id);
    }

    public function  getFullNameUser() {
        return ProfileHelper::profileFullName($this->user_id);
    }

    public function olympicUserRelation($id) {
        return self::find()->where(['id' => $id]);
    }

    public function olympicUserDiploma() {
        return DiplomaHelper::userDiplomaFirstSecondThree($this->user_id, $this->olympiads_id);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_olimpiads';
    }

    public function attributeLabels()
    {
        return [
            'updated_at' => "Дата обновления",
            'created_at' => "Дата создания",
        ];
    }

}