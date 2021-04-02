<?php


namespace modules\dictionary\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\queries\SettingEntrantQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%volunteering}}".
 *
 * @property integer $id
 * @property integer $type
 * @property integer $faculty_id
 * @property integer $edu_level
 * @property integer $form_edu
 * @property integer $finance_edu
 * @property boolean $is_vi
 * @property boolean $foreign_status
 * @property boolean $tpgu_status
 * @property integer $special_right
 * @property string $datetime_start
 * @property string $note
 * @property string $datetime_end
 *
 **/

class SettingEntrant extends ActiveRecord
{
    const ZUK = 1;
    const ZOS = 2;
    const ZID = 3;

    public static function create(SettingEntrantForm $form)
    {
        $entrant = new static();
        $entrant->data($form);
        return $entrant;
    }

    public function data(SettingEntrantForm $form)
    {
        $this->faculty_id = $form->faculty_id;
        $this->form_edu = $form->form_edu;
        $this->finance_edu = $form->finance_edu;
        $this->special_right = $form->special_right;
        $this->note = $form->note;
        $this->is_vi = $form->is_vi;
        $this->type = $form->type;
        $this->datetime_start = $form->datetime_start;
        $this->datetime_end = $form->datetime_end;
        $this->edu_level = $form->edu_level;
        $this->foreign_status = $form->foreign_status;
        $this->tpgu_status = $form->tpgu_status;
    }

    public function getTypeList(): array
    {
        return [self::ZUK => "ЗУК", self::ZOS => "ЗОС", self::ZID => "ЗИД"];
    }

    public function getTypeName(): string
    {
        return $this->getTypeList()[$this->type];
    }

    public static function tableName()
    {
        return "{{%setting_entrant}}";
    }

    public function getFaculty() {
        return DictFacultyHelper::facultyListSetting()[$this->faculty_id];
    }

    public function getSpecialRight() {
        return DictCompetitiveGroupHelper::getSpecialRight()[$this->special_right];
    }

    public function getEduLevel() {
        return DictCompetitiveGroupHelper::getEduLevelsAbbreviated()[$this->edu_level];
    }

    public function getFormEdu() {
        return DictCompetitiveGroupHelper::getEduForms()[$this->form_edu];
    }

    public function getFinanceEdu() {
        return DictCompetitiveGroupHelper::listFinances()[$this->finance_edu];
    }

    public function attributeLabels()
    {
        return [
            'faculty_id' => "Подразделение",
            'form_edu' => "Форма обучения",
            'finance_edu' => "Бюджет/договор",
            'is_vi' => "Вступительное испытание?",
            'type' => "Тип",
            'edu_level' => "Уровень образования",
            'special_right' => "Квота/целевое",
            'datetime_start'  => "Дата начала",
            'datetime_end'  => "Дата завершения",
            'note' => "Описание",
            'tpgu_status' => "Только для ТПГУ",
            'foreign_status' => 'Только для УМС'
        ];
    }
    public static function find(): SettingEntrantQuery
    {
        return  new SettingEntrantQuery(static::class);
    }
}