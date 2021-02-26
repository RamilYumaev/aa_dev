<?php

namespace modules\management\searches;


use modules\management\models\DateWork;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DateWorkSearch extends Model
{
    public $holiday, $workday;

    public function rules()
    {
        return [
            [['holiday', 'workday'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DateWork::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'holiday', $this->holiday])
            ->andFilterWhere(['like', 'workday', $this->workday]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DateWork())->attributeLabels();
    }

}