<?php

namespace modules\management\searches;


use modules\management\models\DictDepartment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictDepartmentSearch extends Model
{
    public $name, $name_short;

    public function rules()
    {
        return [
            [['name', 'name_short'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictDepartment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_short', $this->name_short]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictDepartment())->attributeLabels();
    }

}