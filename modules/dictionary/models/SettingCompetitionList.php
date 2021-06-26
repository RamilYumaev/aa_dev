<?php


namespace modules\dictionary\models;

use modules\dictionary\forms\SettingCompetitionListForm;
use modules\dictionary\models\queries\SettingCompetitionListQuery;
use modules\entrant\helpers\DateFormatHelper;
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
 * @property string $end_date_zuk
 * @property string $is_auto
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
        $this->end_date_zuk = $form->end_date_zuk;
        $this->is_auto = $form->is_auto;
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
            'time_start' => "Время начала",
            'time_end' => "Время завершения",
            'time_start_week' => 'Время начала в субботу/воскресенье',
            'time_end_week' => 'Время завершения в субботу/воскресенье',
            'date_ignore' => 'Игнор конкретных дат',
            'interval' => 'Интервал',
            'end_date_zuk'=> "Дата начала со статусом 1",
            'is_auto' => "Автоматическое обновление?"
        ];
    }


    public function getRegisterCompetitionList()
    {
        return $this->hasMany(RegisterCompetitionList::class, ['se_id'=> 'se_id']);
    }

    public function isEndDateZuk()
    {
        return $this->end_date_zuk && $this->end_date_zuk <= date('Y-m-d H:i:s');
    }

    public function getRegisterCompetitionListForDateAisType($date, $aisCgId, $typeUpdate)
    {
        return $this->getRegisterCompetitionList()
            ->andWhere([
                'date'=> $date,
                'ais_cg_id' => $aisCgId,
                'type_update' => $typeUpdate
            ]);
    }


    public function getSettingEntrant()
    {
        return $this->hasOne(SettingEntrant::class, ['id'=> 'se_id']);
    }

    public function getIntTimeWork($date) {
        if(DateFormatHelper::isWeekEnd($date)) {
            $result = strtotime($this->time_end_week) - strtotime($this->time_start_week);
        } else {
            $result = strtotime($this->time_end) - strtotime($this->time_start);
        }
        return $result / $this->interval;
    }

    public function getDateIgnore() {
        return   implode(', ', json_decode($this->date_ignore));
    }

    public static function find(): SettingCompetitionListQuery
    {
        return  new SettingCompetitionListQuery(static::class);
    }
}