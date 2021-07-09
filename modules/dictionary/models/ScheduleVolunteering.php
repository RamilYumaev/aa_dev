<?php


namespace modules\dictionary\models;
use modules\dictionary\forms\DictScheduleForm;
use modules\dictionary\helpers\JobEntrantHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%schedule_volunteering}}".
 *
 * @property integer $id
 * @property integer $dict_schedule_id
 * @property integer $job_entrant_id
 *
 **/

class ScheduleVolunteering extends ActiveRecord
{
    public static function create($dictScheduleId, $jobEntrantId)
    {
        $model = new static();
        $model->job_entrant_id = $jobEntrantId;
        $model->dict_schedule_id = $dictScheduleId;
        return $model;
    }

    public static function tableName()
    {
        return "{{%schedule_volunteering}}";
    }

    public function getDictSchedule() {
        return  $this->hasOne(DictSchedule::class, ['id' => 'dict_schedule_id']);
    }

    public function getJobEntrant() {
        return  $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_id']);
    }

    public function getReworkingVolunteering() {
        return  $this->hasOne(ReworkingVolunteering::class, ['schedule_volunteering_id' => 'id']);
    }


    public function attributeLabels()
    {
        return [
            'job_entrant_id' => "Сотрудник",
            'dict_schedule_id' => "Данные графика работы",
        ];
    }

    public static function isDateWork($date, $jobEntrantId)
    {
        return self::find()->joinWith('dictSchedule')->andWhere(['date' => $date, 'job_entrant_id' => $jobEntrantId])->exists();
    }
}