<?php

namespace modules\management\searches;


use modules\management\models\DictTask;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictTaskSearch extends Model
{
    public $name, $description;

    public function rules()
    {
        return [
            [['name', 'description'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictTask::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'name', $this->name]);


        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictTask())->attributeLabels();
    }

}