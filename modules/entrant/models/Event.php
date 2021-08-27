<?php

namespace modules\entrant\models;

use dictionary\models\DictCompetitiveGroup;

use modules\entrant\forms\EventForm;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event".
 *
 * @property int $id
 * @property int $is_published
 * @property string|null $date
 * @property int $type
 * @property string|null $place
 * @property string|null $name_src
 * @property string|null $src
 *
 */
class Event extends \yii\db\ActiveRecord
{

    const DISTANCE = 1;
    const INTERNAL = 2;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event';
    }

    public static function create(EventForm $form)
    {
        $event = new static();
        $event->data($form);
        return $event;
    }

    public function data(EventForm $form) {
        $this->type = $form->type;
        $this->date = $form->date;
        $this->src = $form->src;
        $this->name_src = $form->name_src;
    }


    public function getTypes() {
        return [
            self::DISTANCE => 'Дистанционный',
            self::INTERNAL => 'Очный',
        ];
    }

    public function getTypeName() {
        return $this->getTypes()[$this->type];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cg_id' => 'Конкурсная группа',
            'date' => 'Дата и время',
            'type' => 'Формат',
            'place' => 'Место проведения',
            'name_src' => 'Наименование ссылки',
            'src' => 'Ссылка',
            'faculty_id' => "Факультет/Институт",
            'edu_level' => "Уровень",
            'form_id' => 'Форма обучения'
        ];
    }

    public function getEventCg() {
        return $this->hasMany(EventCg::class, ['event_id' => 'id']);
    }

    public function getCgIds() {
       return implode('; ',\yii\helpers\ArrayHelper::map($this->eventCg, 'cg_id', 'cg.fullNameV'));
    }

    public function getFacultyIds() {
        return implode('; ',\yii\helpers\ArrayHelper::map($this->eventCg, 'cg.faculty_id', 'cg.faculty.full_name'));
    }

    public function getEduLevelIds() {
        return implode('; ',\yii\helpers\ArrayHelper::map($this->eventCg, 'cg.edu_level', 'cg.eduLevel'));
    }

    public function getFormIds() {
        return implode('; ',\yii\helpers\ArrayHelper::map($this->eventCg, 'cg.education_form_id', 'cg.formEdu'));
    }

    public static function columnCg() {
        $query = DictCompetitiveGroup::find()->currentAutoYear()->foreignerStatus(0)->all();
        return ArrayHelper::map($query, 'id', 'fullName');
    }
}
