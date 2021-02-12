<?php
namespace modules\management\models;

use modules\management\behaviors\HistoryTaskBehavior;
use modules\management\forms\TaskForm;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * @property $title string
 * @property $text string
 * @property $dict_task_id integer
 * @property $director_user_id integer
 * @property $responsible_user_id integer
 * @property $status integer
 * @property $date_begin string
 * @property $position integer
 * @property $date_end string
 * @property $id integer
 */
class Task extends ActiveRecord
{
    const STATUS_NEW  = 1;
    const STATUS_WORK = 2;
    const STATUS_DONE = 3;
    const STATUS_REWORK = 4;
    const STATUS_ACCEPTED_TO_TIME = 5;
    const STATUS_ACCEPTED_WITCH_OVERDUE = 6;
    const STATUS_NOT_EXECUTED = 7;


    public function behaviors()
    {
        return ['history' => [
            'class'=> HistoryTaskBehavior::class,
            'attributes'=>['title', 'dict_task_id', 'status',
                'director_user_id', 'responsible_user_id', 'position', 'date_begin','date_end'],
        ]];
    }

    public static function tableName()
    {
        return "{{task}}";
    }

    public static function create(TaskForm $form)
    {
        $model = new static();
        $model->data($form);
        return $model;
    }

    public function data(TaskForm $form)
    {
        $this->title = $form->title;
        $this->text = $form->text;
        $this->dict_task_id = $form->dict_task_id;
        $this->director_user_id = $form->director_user_id;
        $this->position =  $form->position;
        $this->responsible_user_id = $form->responsible_user_id;
        $this->date_begin = $form->date_begin;
        $this->date_end = $form->date_end;
    }

    public function attributeLabels()
    {
        return [
            "id" => "ID",
            "title" => "Заголовок",
            "text" => "Описание",
            'dict_task_id' =>  "Функция",
            'director_user_id' =>  "Постановщик",
            'responsible_user_id' => 'Ответственный',
            'date_begin' => 'Дата постановки',
            'status' => 'Статус',
            'statusName' => 'Статус',
            'position' => "Приоритет задачи",
            'date_end' =>  "Крайный срок",
        ];
    }

    public function getDirectorProfile() {
        return $this->hasOne(Profiles::class, ['user_id' => 'director_user_id']);
    }

    public function getResponsibleProfile() {
        return $this->hasOne(Profiles::class, ['user_id' => 'responsible_user_id']);
    }

    public function getDirectorSchedule() {
        return $this->hasOne(Schedule::class, ['user_id' => 'director_user_id']);
    }

    public function getResponsibleSchedule() {
        return $this->hasOne(Schedule::class, ['user_id' => 'responsible_user_id']);
    }

    public function getDictTask() {
        return $this->hasOne(DictTask::class, ['id' => 'dict_task_id']);
    }

    public function getHistoryTasks() {
        return $this->hasMany(HistoryTask::class, ['task_id' => 'id']);
    }

    public function getStatusList() {
        return [
            self::STATUS_NEW => ['name' => "Новая", 'color'=> 'warning'],
            self::STATUS_WORK => ['name' => "Взято в работу", 'color'=> 'primary'],
            self::STATUS_DONE => ['name' => "Выполнено", 'color'=> 'success'],
            self::STATUS_REWORK => ['name' => "Доработка", 'color'=> 'info'],
            self::STATUS_ACCEPTED_TO_TIME => ['name' => "Приянто в срок", 'color'=> 'olive'],
            self::STATUS_ACCEPTED_WITCH_OVERDUE => ['name' => "Приянто с просроченной", 'color'=> 'orange'],
            self::STATUS_NOT_EXECUTED => ['name' => "Не выполнено", 'color'=> 'danger'],
        ];
    }

    public function getStatusName () {
        return $this->getStatusList()[$this->status]['name'];
    }

    public function getStatusColor () {
        return $this->getStatusList()[$this->status]['color'];
    }

    /**
     * @throws \Exception
     */
    public function getDay(){
        $date = new \DateTimeImmutable($this->date_begin);
        return strtolower($date->format('l'));
    }

}