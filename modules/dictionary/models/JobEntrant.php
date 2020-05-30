<?php


namespace modules\dictionary\models;

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

    public function getStatusName() {
        return JobEntrantHelper::statusList()[$this->status];
    }

    public function isStatusDraft() {
        return $this->status == JobEntrantHelper::DRAFT;
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