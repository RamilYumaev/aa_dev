<?php

namespace modules\management\models;


use modules\management\forms\ScheduleForm;
use modules\management\models\queries\ScheduleQuery;
use olympic\models\auth\Profiles;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%schedule}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $rate
 * @property integer $vacation
 * @property string $email
 * @property string $monday_even
 * @property string $tuesday_even
 * @property string $wednesday_even
 * @property string $thursday_even
 * @property string $friday_even
 * @property string $saturday_even
 * @property string $sunday_even
 * @property string $monday_odd
 * @property string $tuesday_odd
 * @property string $wednesday_odd
 * @property string $thursday_odd
 * @property string $friday_odd
 * @property string $saturday_odd
 * @property string $sunday_odd
 **/

class Schedule extends ActiveRecord
{
    const FULL_RATE = 39;
    const HALF_QUARTER_RATE = 30;
    const HALF_RATE = 20;
    const QUARTER_RATE = 10;
    const LUNCH_TIME = 2700;

    public static function tableName()
    {
        return '{{%schedule}}';
    }

    public function setDataForm(ScheduleForm $form)
    {
        $this->rate = $form->rate;
        $this->vacation = $form->vacation;
        $this->email = $form->email;
        $this->monday_even = $form->monday_even;
        $this->monday_odd = $form->monday_odd;
        $this->tuesday_even = $form->tuesday_even;
        $this->tuesday_odd = $form->tuesday_odd;
        $this->wednesday_even = $form->wednesday_even;
        $this->wednesday_odd = $form->wednesday_odd;
        $this->thursday_even = $form->thursday_even;
        $this->thursday_odd = $form->thursday_odd;
        $this->friday_even = $form->friday_even;
        $this->friday_odd = $form->friday_odd;
        $this->saturday_even = $form->saturday_even;
        $this->saturday_odd = $form->saturday_odd;
        $this->sunday_even = $form->sunday_even;
        $this->sunday_odd = $form->sunday_odd;
        $this->user_id = $form->user_id;
    }

    public function getCountHours($week){
        $sum = 0;
        $daysExcept = $week == 'even' ?
            ['monday_odd', 'tuesday_odd', 'wednesday_odd', 'thursday_odd', 'friday_odd', 'saturday_odd', 'sunday_odd'] :
            ['monday_even', 'tuesday_even', 'wednesday_even', 'thursday_even', 'friday_even', 'saturday_even', 'sunday_even'];
        $except = array_merge(['user_id', 'id', 'email', 'vacation', 'rate'], $daysExcept);
        foreach ($this->getAttributes(null, $except) as  $key => $value) {
            if($value) {
                 $times = explode('-', $value);
                 $timeLunch =  $this->rate == self::FULL_RATE ? self::LUNCH_TIME: 0;
                 $timeBegin = strtotime($times[0]);
                 $timeEnd = strtotime($times[1]);
                 $total = ($timeEnd-$timeBegin-$timeLunch)/3600;
                 $sum += $total;
            }
        }
        return $sum;
    }

    public function getAllDateTwoWeek($date)
    {
        $begin = new \DateTime($date);
        $days = [];
        $twoWeek = new \DateTime($date);
        $twoWeek->modify('+12 week');
        $end = new \DateTime($twoWeek->format("Y-m-d"));
        for($i = $begin; $i <= $end; $i->modify('+1 day')) {
            $date =  new \DateTime($i->format("Y-m-d"));
            $day = $date->format("l");
            $week = $date->format('W') % 2 == 0 ? '_even' : '_odd';
            $date = $date->format("m-d-Y");
            $column = strtolower($day).$week;
            if ($this->{$column}) {
                $days[$date] = $date;
            }
        }
        return $days;
    }

    public function getAllTimeWork($date)
    {
        $date= new \DateTime($date);
        $day = $date->format("l");
        $timeArray = [];
        $week = $date->format('W') % 2 == 0 ? '_even' : '_odd';
        $column = strtolower($day).$week;
        $value = $this->{$column};

        if($value) {
            $times = explode("-", $value);
            $beginTime = new \DateTime($times[0]);
            $endTime = new \DateTime($times[1]);
            for($i = $beginTime; $i <= $endTime; $i->modify('+15 minute')) {
                    $time = $i->format("H:i");
                    $timeArray[$time] = $time;
            }

        }
        return $timeArray;
    }

    public function getRateList() {
        return [
            self::FULL_RATE => 'Полная ставка',
            self::HALF_QUARTER_RATE => '0,75 ставки',
            self::HALF_RATE => '0,5 ставки',
            self::QUARTER_RATE => '0,25 ставки',
        ];
    }

    public function getRateName () {
        return $this->getRateList()[$this->rate];
    }

    public function getProfile() {
        return $this->hasOne(Profiles::class, ['user_id' => 'user_id']);
    }

    public function getManagementPosts() {
        return $this->hasMany(ManagementUser::class, ['user_id' => 'user_id']);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ИД',
            'user_id' => 'Сотрудник',
            'monday_even' => 'Понедельник',
            'tuesday_even' => 'Вторник',
            'wednesday_even' => 'Среда',
            'thursday_even' => 'Четверг',
            'friday_even' => 'Пятница',
            'saturday_even' => 'Суббота',
            'sunday_even' => 'Воскресенье',
            'monday_odd' => 'Понедельник',
            'tuesday_odd' => 'Вторник',
            'wednesday_odd' => 'Среда',
            'thursday_odd' => 'Четверг',
            'friday_odd' => 'Пятница',
            'saturday_odd' => 'Суббота',
            'sunday_odd' => 'Воскресенье',
            'rate' => 'Рабочая ставка',
            'rateName' => 'Рабочая ставка',
            'vacation' => 'В отпуске?',
            'email' => 'Рабочая электронная почта'
        ];
    }

    public static function find(): ScheduleQuery
    {
        return new ScheduleQuery(static::class);
    }
}