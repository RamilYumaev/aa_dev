<?php

namespace modules\dictionary\searches;

use modules\dictionary\models\DictTestingEntrant;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictTestingEntrantSearch extends Model
{
    public $name;
    public $priority;
    public $is_auto;

    public function rules()
    {
        return [
            [['name'], 'safe'],
            [['priority', 'is_auto'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictTestingEntrant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['is_auto' => $this->is_auto, 'priority' => $this->priority]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictTestingEntrant())->attributeLabels();
    }
}