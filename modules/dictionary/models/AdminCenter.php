<?php


namespace modules\dictionary\models;
use modules\dictionary\forms\AdminCenterForm;
use modules\dictionary\helpers\JobEntrantHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%schedule_volunteering}}".
 *
 * @property integer $id
 * @property integer $job_entrant_id
 * @property integer $category
 *
 **/

class AdminCenter extends ActiveRecord
{
    public static function create(AdminCenterForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(AdminCenterForm $form)
    {
        $this->job_entrant_id = $form->job_entrant_id;
        $this->category= $form->category;
    }


    public static function tableName()
    {
        return "{{%admin_center}}";
    }

    public function getCategoryName() {
        return JobEntrantHelper::listVolunteeringCategories()[$this->category];
    }


    public function getJobEntrant() {
        return  $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_id']);
    }

    public function getEntrantJob() {
        return $this->getJobEntrant()->joinWith('profileUser');
    }

    /**
     * @return array
     */
    public function allColumn(): array
    {
        return self::find()->joinWith('entrantJob')
            ->select(['CONCAT(last_name, \' \', first_name, \' \', patronymic)'])
            ->indexBy('job_entrant_id')->column();
    }


    public function attributeLabels()
    {
        return [
            'job_entrant_id' => "Сотрудник",
            'category' => "Центр",
        ];
    }
}