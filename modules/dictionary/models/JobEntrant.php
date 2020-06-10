<?php


namespace modules\dictionary\models;

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
 * @property integer $status;
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
        $this->faculty_id = $this->category_id == JobEntrantHelper::FOK ? $form->faculty_id : null;
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

    public function getFaculty() {
        return $this->hasOne(Faculty::class, ['id' => 'faculty_id']);
    }

    public function getCategory() {
        return JobEntrantHelper::listCategories()[$this->category_id];
    }

    public function isCategoryCOZ() {
        return $this->category_id == JobEntrantHelper::COZ;
    }

    public function isAgreement() {
        return $this->category_id == JobEntrantHelper::AGREEMENT;
    }

    public function isCategoryUMS() {
        return $this->category_id == JobEntrantHelper::UMS;
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

    public function getStatusName() {
        return JobEntrantHelper::statusList()[$this->status];
    }

    public function isStatusDraft() {
        return $this->status == JobEntrantHelper::DRAFT;
    }

    public function getFullNameJobEntrant() {
         if($this->isCategoryFOK()) {
             return $this->category.". ".$this->faculty->full_name;
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
        ];
    }
}