<?php

namespace modules\management\searches;


use modules\management\models\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Model
{
    public $title;

    public function rules()
    {
        return [
            ['title', 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Task::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new Task())->attributeLabels();
    }

}