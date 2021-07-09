<?php


namespace modules\dictionary\models;
use modules\dictionary\forms\ReworkingVolunteeringForm;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%reworking_volunteering}}".
 *
 * @property integer $id
 * @property integer $schedule_volunteering_id
 * @property string $text
 * @property integer $count_hours
 * @property integer $status
 * @property integer $job_entrant_admin_id
 * @property string $recall_text
 *
 **/

class ReworkingVolunteering extends ActiveRecord
{
    const WATCH = 0;

    const SUCCESS_ADMIN = 1;
    const RECALL_ADMIN = 2;

    const SUCCESS_DIRECTOR = 3;
    const RECALL_DIRECTOR = 4;

    public static function create(ReworkingVolunteeringForm $form, $scheduleVolunteeringId)
    {
        $model = new static();
        $model->data($form);
        $model->schedule_volunteering_id = $scheduleVolunteeringId;
        return $model;
    }

    public function data(ReworkingVolunteeringForm $form)
    {
        $this->count_hours = $form->count_hours;
        $this->text = $form->text;
    }

    public function getStatusList() {
        return [
            self::WATCH => 'На рассмотрении',
            self::SUCCESS_ADMIN => 'Принято админом центра',
            self::RECALL_ADMIN => 'Отказано админом центра',
            self::SUCCESS_DIRECTOR => 'Принято',
            self::RECALL_DIRECTOR => 'Отказано',
        ];
    }

    public function getStatusName() {
        return  $this->statusList[$this->status];
    }

    public function isStatusWatch() {
        return $this->status == self::WATCH;
    }

    public function isStatusSuccess() {
        return $this->status == self::SUCCESS_DIRECTOR || $this->status == self::SUCCESS_ADMIN;
    }

    public function isStatusRecall() {
        return $this->status == self::RECALL_DIRECTOR || $this->status == self::RECALL_ADMIN;
    }

    public function setRecallText($text, $status)
    {
        $this->recall_text = $text;
        $this->setStatus($status);
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public static function tableName()
    {
        return "{{%reworking_volunteering}}";
    }

    public function getDictSchedule() {
        return  $this->hasOne(ScheduleVolunteering::class, ['id' => 'schedule_volunteering_id']);
    }

    public function getJobEntrant() {
        return  $this->hasOne(JobEntrant::class, ['id' => 'job_entrant_admin_id']);
    }

    public function attributeLabels()
    {
        return [
            'job_entrant_admin_id' => "Админ центра",
            'schedule_volunteering_id' => 'Данные волонтера',
            'text' => "Текст в свободной форме",
            'count_hours' => 'Количество часов',
            'status' => 'Статус',
            'recall_text' => 'Причина отказа',
        ];
    }
}