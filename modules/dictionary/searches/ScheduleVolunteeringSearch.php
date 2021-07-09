<?php

namespace modules\dictionary\searches;

use modules\dictionary\models\DictSchedule;
use modules\dictionary\models\JobEntrant;
use modules\dictionary\models\ScheduleVolunteering;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ScheduleVolunteeringSearch extends Model
{
    public $date, $count, $category;
    private $jobEntrant;

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['count', 'category'], 'integer'],
        ];
    }

    public function __construct(JobEntrant $jobEntrant, $config = [])
    {
        $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = ScheduleVolunteering::find()->joinWith('dictSchedule')
            ->andWhere([ 'job_entrant_id' => $this->jobEntrant->id])->orderBy(['date'=> SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['count' => $this->count])
            ->andFilterWhere(['category' => $this->category]);

        $query
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictSchedule())->attributeLabels();
    }

}