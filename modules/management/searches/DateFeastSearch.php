<?php

namespace modules\management\searches;


use modules\management\models\DateFeast;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DateFeastSearch extends Model
{
    public $date;

    public function rules()
    {
        return [
            [['date'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DateFeast::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DateFeast())->attributeLabels();
    }

}