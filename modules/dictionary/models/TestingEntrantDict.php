<?php

namespace modules\dictionary\models;


use common\moderation\behaviors\ModerationBehavior;
use common\moderation\interfaces\YiiActiveRecordAndModeration;
use modules\dictionary\forms\DictCategoryForm;
use modules\management\repositories\ScheduleRepository;
use yii\db\ActiveRecord;

/**
 * Class TestingEntrantDict
 * @package modules\entrant\models
 * @property string $error_note
 * @property integer $status
 * @property integer $status_programmer
 * @property integer $count_files;
 * @property integer $id_dict_testing_entrant
 * @property integer $id_testing_entrant
 *
 */
class TestingEntrantDict extends ActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_WORK = 1;
    const STATUS_SUCCESS = 2;
    const STATUS_ERROR = 3;
    const STATUS_FIX = 4;
    const STATUS_FIX_SUCCESS = 5;


    public static function tableName()
    {
        return "{{testing_entrant_dict}}";
    }

    public function data($id_dict_testing_entrant, $id_testing_entrant)
    {
        $this->id_dict_testing_entrant = $id_dict_testing_entrant;
        $this->id_testing_entrant =  $id_testing_entrant;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function setCountFiles($count) {
        $this->count_files = $count;
    }

    public function getNameFile($number) {
        return $this->id_dict_testing_entrant."_".$this->id_testing_entrant."_".$number;
    }

    public function setErrorNote($message) {
        $this->error_note = $message;
    }

    public function setStatusProgrammer ($status) {
        $this->status_programmer = $status;
    }

    public function attributeLabels()
    {
        return [
            'id_dict_testing_entrant' => 'Кейс',
            'id_testing_entrant' => 'Задача',
            'status' => 'Статус',
            'error_note' => 'Информация об ошибке',
            'status_programmer' => 'Статус решения проблемы',
            'count_files'=>  'Кол-во скриншотов'
        ];
    }

    public function getDctTestingEntrant()
    {
        return $this->hasOne(DictTestingEntrant::class,['id' => 'id_dict_testing_entrant']);
    }

    public function getTestingEntrant()
    {
        return $this->hasOne(TestingEntrant::class,['id' => 'id_testing_entrant']);
    }

    public function getStatusList() {
        return [
            self::STATUS_NEW => ['name' => "Новая", 'color'=> 'warning'],
            self::STATUS_WORK => ['name' => "Взято в работу", 'color'=> 'primary'],
            self::STATUS_SUCCESS => ['name' => "Принято", 'color'=> 'success'],
            self::STATUS_FIX => ['name' => 'Исправлено', 'color'=> 'info'],
            self::STATUS_FIX_SUCCESS => ['name' => "Принято с исправлением", 'color'=> 'success'],
            self::STATUS_ERROR => ['name' => "Ошибка", 'color'=> 'danger'],
        ];
    }

    public function isStatusNew() {
        return $this->status == self::STATUS_NEW;
    }

    public function isStatusWork() {
        return $this->status == self::STATUS_WORK;
    }

    public function isStatusError() {
        return $this->status == self::STATUS_ERROR;
    }

    public function isStatusSuccess() {
        return $this->status == self::STATUS_SUCCESS;
    }

    public function isStatusFix() {
        return $this->status == self::STATUS_FIX;
    }

    public function isStatusFixSuccess() {
        return $this->status == self::STATUS_FIX_SUCCESS;
    }

    public function getStatusName() {
        return $this->getStatusList()[$this->status]['name'];
    }

    public function getStatusColor() {
        return $this->getStatusList()[$this->status]['color'];
    }
}