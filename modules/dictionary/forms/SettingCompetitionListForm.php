<?php
namespace modules\dictionary\forms;
use modules\dictionary\models\SettingCompetitionList;
use yii\base\Model;

class SettingCompetitionListForm extends Model
{
    public $date_start, $date_end, $time_start, $time_end, $se_id, $time_start_week, $time_end_week, $interval, $date_ignore;

    public function __construct(SettingCompetitionList $competitionList = null, $config = [])
    {
        if($competitionList){
            $this->setAttributes($competitionList->getAttributes(), false);
            $this->date_ignore = json_decode($competitionList->date_ignore);
        }
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_start', 'date_end', 'time_start', 'time_end', 'time_start_week', 'time_end_week', 'interval'], 'required'],
            [['interval', 'se_id'], 'integer'],
            [['date_start', 'date_end'], 'date', 'format' => 'yyyy-M-d'],
            [['date_ignore'],'safe' ],
            [['time_start', 'time_end', 'time_start_week', 'time_end_week'], 'time', 'format' => 'H:m:s'],
        ];
    }

    public function attributeLabels() {
        return (new SettingCompetitionList())->attributeLabels();
    }
}