<?php


namespace modules\dictionary\models;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\forms\SettingEntrantForm;
use modules\dictionary\forms\VolunteeringForm;
use modules\dictionary\models\queries\SettingEntrantQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%setting_competition_list}}".
 *
 * @property integer $se_id
 * @property integer $interval
 * @property string $date_start
 * @property string $date_end
 * @property string $time_start
 * @property string $time_end
 * @property string $time_start_week
 * @property string $time_end_week
 * @property array $date_ignore
 **/

class SettingCompetitionList extends ActiveRecord
{

    public static function create(SettingCompetitionListForm $form)
    {
        $scl = new static();
        $scl->data($form);
        return $scl;
    }

    public function data(SettingCompetitionListForm $form)
    {
        $this->se_id = $form->se_id;
        $this->date_start = $form->date_start;
        $this->date_end = $form->date_end;
        $this->time_start = $form->time_start;
        $this->time_end = $form->time_end;
        $this->time_start_week = $form->time_start_week;
        $this->time_end_week = $form->time_end_week;
        $this->interval = $form->interval;
        $this->date_ignore = json_encode($form->date_ignore);
    }


    public static function tableName()
    {
        return "{{%setting_competition_list}}";
    }

    public function attributeLabels()
    {
        return [
            'date_start' => "Дата начала",
            'date_end' => "Дата завршения",
            'time_start' => "Время начала в рабочей недели",
            'time_end' => "Время завершения в рабочей недели",
            'time_start_week' => 'Время начала в субботу/воскресенье',
            'time_end_week' => 'Время завершения в субботу/воскресенье',
            'date_ignore' => 'Игнорировать конкретные даты',
            'interval' => 'Интервал',
        ];
    }
}