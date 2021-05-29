<?php

namespace modules\dictionary\models;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\forms\TestingEntrantForm;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * Class TestingEntrant
 * @package modules\entrant\models
 * @property string $department
 * @property string $special_right
 * @property string $edu_level
 * @property string $edu_document
 * @property string $country
 * @property string $category
 * @property string $fio
 * @property string $note
 * @property integer $status
 * @property integer $user_id
 * @property string $title
 *
 */
class TestingEntrant extends ActiveRecord
{
    const STATUS_OPEN = 0;
    const STATUS_END = 1;

    public static function tableName()
    {
        return "{{testing_entrant}}";
    }

    public static function create(TestingEntrantForm $form)
    {
        $testing = new static();
        $testing->data($form);
        return $testing;
    }

    public function data(TestingEntrantForm $form)
    {
        $this->department = json_encode($form->department);
        $this->special_right = json_encode($form->special_right);
        $this->edu_level = json_encode($form->edu_level );
        $this->edu_document = $form->edu_document;
        $this->country = $form->country;
        $this->category = $form->category;
        $this->fio = $form->fio;
        $this->note = $form->note;
        $this->user_id = $form->user_id;
        $this->title = $form->title;
    }

    public function setStatus ($status) {
        $this->status = $status;
    }

    public function getTestingEntrantDict() {
        return $this->hasMany(TestingEntrantDict::class,['id_testing_entrant' => 'id']);
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class,['user_id' => 'user_id']);
    }

    public function getDepartmentString() {
        return   implode(', ', array_map(function ($role) {
            return DictFacultyHelper::facultyListSetting()[$role];
        }, json_decode($this->department)));
    }

    public function getSpecialRight() {
        return  implode(', ', array_map(function ($role) {
            return DictCompetitiveGroupHelper::getSpecialRight()[$role];
        }, json_decode($this->special_right)));
    }

    public function getEduLevel() {
        return  implode(', ', array_map(function ($role) {
            return DictCompetitiveGroupHelper::getEduLevelsAbbreviated()[$role];
        }, json_decode($this->edu_level)));
    }

    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'department' => 'Подразделение',
            'special_right' => 'Основание приема',
            'edu_level' => "Уровень образования",
            'edu_document' => 'Документ об образовании',
            'country' => 'Страны',
            'category' => 'Категории',
            'title' => 'Заголовок',
            'fio' => 'ФИО  в произвольной форме',
            'user_id'=> 'Волонтер',
            'note' => 'Примечание',
            'status' => 'Статус задачи'
        ];
    }

    public function getStatusList() {
        return [
            self::STATUS_OPEN => ['name' => "Открыто", 'color'=> 'warning'],
            self::STATUS_END => ['name' => "Зввершено", 'color'=> 'success'],
        ];
    }

    public function getStatusName() {
        return $this->getStatusList()[$this->status]['name'];
    }

    public function getStatusColor() {
        return $this->getStatusList()[$this->status]['color'];
    }

    public function isStatusOpen() {
        return $this->status == self::STATUS_OPEN;
    }

    public function isStatusEnd() {
        return $this->status == self::STATUS_END;
    }
}