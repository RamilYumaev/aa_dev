<?php


namespace modules\dictionary\models;

use common\auth\models\SettingEmail;
use common\auth\models\User;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\Faculty;
use modules\dictionary\forms\JobEntrantForm;
use modules\dictionary\helpers\JobEntrantHelper;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%job_entrant}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $category_id
 * @property integer $faculty_id
 * @property integer $email_id
 * @property integer $examiner_id
 * @property integer $right_full
 * @property integer $post
 * @property integer $status
 *
 **/

class JobEntrant extends ActiveRecord
{

    public static function create(JobEntrantForm $form)
    {
        $entrant = new static();
        $entrant->data($form);
        return $entrant;
    }

    public function data(JobEntrantForm $form)
    {
        $this->user_id = $form->user_id;
        $this->category_id = $form->category_id;
        $this->faculty_id = $this->category_id == JobEntrantHelper::FOK ||
            $this->category_id == JobEntrantHelper::TRANSFER ?
            $form->faculty_id : null;
        $this->examiner_id = $this->category_id == JobEntrantHelper::EXAM ? $form->examiner_id : null;
        $this->email_id = $form->email_id ?? null;
        $this->right_full = $form->right_full;
        $this->post = $form->post ?? null;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public static function tableName()
    {
        return "{{%job_entrant}}";
    }

    public function getProfileUser() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getUser() {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getSettingEmail() {
        return $this->hasOne(SettingEmail::class, ['id' => 'email_id']);
    }

    public function getFaculty() {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getExaminer() {
        return $this->hasOne(DictExaminer::class, ['id' => 'examiner_id']);
    }

    public function getVolunteering() {
        return $this->hasOne(Volunteering::class, ['job_entrant_id' => 'id']);
    }

    public function getCategory() {
        return JobEntrantHelper::listCategories()[$this->category_id];
    }

    public function getPostName() {
        return JobEntrantHelper::postList()[$this->post];
    }

    public function isCategoryCOZ() {
        return $this->category_id == JobEntrantHelper::COZ;
    }

    public function isAgreement() {
        return $this->category_id == JobEntrantHelper::AGREEMENT;
    }

    public function isTransferFok() {
        return $this->category_id == JobEntrantHelper::TRANSFER;
    }

    public function isCategoryUMS() {
        return $this->category_id == JobEntrantHelper::UMS;
    }

    public function isTPGU(){
        return $this->category_id == JobEntrantHelper::TPGU;
    }

    public function isCategoryTarget() {
        return $this->category_id == JobEntrantHelper::TARGET;
    }

    public function isCategoryFOK() {
        return $this->category_id == JobEntrantHelper::FOK;
    }

    public function isCategoryMPGU() {
        return $this->category_id == JobEntrantHelper::MPGU;
    }

    public function isCategoryGraduate() {
        return $this->category_id == JobEntrantHelper::GRADUATE;
    }

    public function isCategoryCollage() {
        return $this->category_id == DictFacultyHelper::COLLAGE;
    }

    public function isCategoryExam() {
        return $this->category_id == JobEntrantHelper::EXAM || $this->isTransferFok();
    }

    public function getStatusName() {
        return JobEntrantHelper::statusList()[$this->status];
    }

    public function isStatusDraft() {
        return $this->status == JobEntrantHelper::DRAFT;
    }

    public function getFullNameJobEntrant() {
         if($this->isCategoryFOK() || $this->isTransferFok()) {
             return $this->category.". ".$this->faculty->full_name;
         }elseif ($this->isCategoryExam()) {
             return $this->category.". ".$this->examiner->fio;
         }
        return $this->category;
    }

    public function attributeLabels()
    {
        return [
            'category_id' => 'Подразделение',
            'user_id' => "Пользователь",
            'faculty_id' => 'Факультет',
            'status' => 'Статус',
            'examiner_id' => "Председатель экзаменационной комиссии",
            'email_id' => "Email  для рассылки",
            'right_full' => "Неограниченные права",
            'post' => "Должность",
        ];
    }

    public function allColumn(): array
    {
        return self::find()->joinWith('profileUser')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])
            ->indexBy('job_entrant.id')->column();
    }
}