<?php

namespace modules\management\searches;


use modules\management\models\Task;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Model
{
    public $title, $dict_task_id,  $director_user_id, $responsible_user_id, $status, $position;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['dict_task_id',
            'director_user_id',
            'responsible_user_id',
                'position',
                'status'],'integer'],
            ['title', 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
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

        $query->filterWhere([
            'director_user_id' => $this->director_user_id,
            'responsible_user_id'=> $this->responsible_user_id,
            'dict_task_id'=> $this->dict_task_id,
            'status'=> $this->status,
            'position' => $this->position,
        ]);
        $query
            ->andFilterWhere(['like', 'title', $this->title])

        ->andFilterWhere(['>=', 'date_end', $this->date_from ? $this->date_from . ' 00:00:00' : null])
        ->andFilterWhere(['<=', 'date_end', $this->date_to ?  $this->date_to . ' 23:59:59' : null]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new Task())->attributeLabels();
    }

}