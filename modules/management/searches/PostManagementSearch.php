<?php

namespace modules\management\searches;


use modules\management\models\PostManagement;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PostManagementSearch extends Model
{
    public $name;

    public function rules()
    {
        return [
            ['name', 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = PostManagement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new PostManagement())->attributeLabels();
    }

}