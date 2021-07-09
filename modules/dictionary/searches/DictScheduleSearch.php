<?php

namespace modules\dictionary\searches;

use modules\dictionary\models\DictSchedule;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictScheduleSearch extends Model
{
    public $date, $count, $category;

    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['count', 'category'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictSchedule::find()->orderBy(['date'=> SORT_DESC]);

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