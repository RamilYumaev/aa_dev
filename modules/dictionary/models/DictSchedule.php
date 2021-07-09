<?php
namespace modules\dictionary\models;
use modules\dictionary\forms\DictScheduleForm;
use modules\dictionary\helpers\JobEntrantHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%dict_schedule}}".
 *
 * @property integer $id
 * @property integer $category
 * @property integer $count
 * @property string $date
 *
 **/

class DictSchedule extends ActiveRecord
{
    public static function create(DictScheduleForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(DictScheduleForm $form)
    {
        $this->date = $form->date;
        $this->category = $form->category;
        $this->count = $form->count;
    }

    public static function tableName()
    {
        return "{{%dict_schedule}}";
    }

    public function getCategoryName() {
        return JobEntrantHelper::listVolunteeringCategories()[$this->category];
    }

    public function getScheduleVolunteering() {
        return $this->hasMany(ScheduleVolunteering::class, ['dict_schedule_id' => 'id']);
    }

    public function getScheduleVolunteeringCount() {
        return $this->getScheduleVolunteering()->count();
    }

    public function isCountEnd() {
        return $this->getScheduleVolunteeringCount() >= $this->count;
    }

    public function isEntrant($jobEntrant) {
        return $this->getScheduleVolunteering()->andWhere(['job_entrant_id' => $jobEntrant])->exists();
    }

    public function attributeLabels()
    {
        return [
            'date' => "Дата рабочего дня",
            'count' => "Количество волонтеров",
            'category' => "Центр",
        ];
    }
}