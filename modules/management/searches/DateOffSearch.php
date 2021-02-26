<?php

namespace modules\management\searches;


use modules\management\models\DateOff;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DateOffSearch extends Model
{
    public $date, $schedule_id, $isAllowed;

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['schedule_id', 'isAllowed'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DateOff::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->filterWhere(['schedule_id' => $this->schedule_id,
            'isAllowed' => $this->isAllowed]);
        $query
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DateOff())->attributeLabels();
    }

}