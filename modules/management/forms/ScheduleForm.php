<?php


namespace modules\management\forms;

use modules\management\models\Schedule;
use yii\base\Model;

class ScheduleForm extends Model
{
    public $monday_even, $tuesday_even, $wednesday_even, $thursday_even, $friday_even, $saturday_even, $sunday_even,
        $monday_odd, $tuesday_odd, $wednesday_odd, $thursday_odd, $friday_odd, $saturday_odd, $sunday_odd,
        $user_id, $vacation, $email;
    private $_schedule;
    public $postList;

    public function __construct(Schedule $schedule = null, $userId = null, $config = [])
    {
        if ($schedule) {
            $this->setAttributes($schedule->getAttributes(), false);
            $this->postList = $schedule->getManagementPosts()->select('post_rate_id')->column();
            $this->_schedule = $schedule;

        }else {
            $this->postList = [];
        }
        if ($userId) {
            $this->user_id = $userId;
        }
        parent::__construct($config);
    }

    public function defaultRules()
    {
        return [
            [['monday_even', 'tuesday_even', 'wednesday_even', 'thursday_even', 'friday_even', 'saturday_even', 'sunday_even',
                'monday_odd', 'tuesday_odd', 'wednesday_odd', 'thursday_odd', 'friday_odd', 'saturday_odd', 'sunday_odd' ], 'string', 'max'=> 11],
            [['email', 'vacation', 'postList'], 'required' ],
            [['postList'], 'safe' ],
            [['email'],'email'],
            [['vacation'], 'boolean'],
        ];
    }

    public function uniqueRules()
    {
        $arrayUnique = [['user_id','email'], 'unique', 'targetClass' => Schedule::class];
        if ($this->_schedule) {
            return array_merge($arrayUnique, ['filter' => ['<>', 'id', $this->_schedule->id]]);
        }
        return $arrayUnique;
    }

    public function rules()
    {
        return array_merge($this->defaultRules(), [$this->uniqueRules()]);
    }

    public function attributeLabels()
    {
        return (new Schedule())->attributeLabels()+['postList'=> "Должность/Ставка/Отдел"];
    }


}