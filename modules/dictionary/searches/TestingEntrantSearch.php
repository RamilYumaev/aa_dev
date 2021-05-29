<?php

namespace modules\dictionary\searches;

use modules\dictionary\models\DictTestingEntrant;
use modules\dictionary\models\TestingEntrant;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TestingEntrantSearch extends Model
{
    public $department;
    public $special_right;
    public $edu_level;
    public $edu_document;
    public $country;
    public $category;
    public $fio;
    public $note;
    public $title;
    public $user_id;
    public $status;

    public function rules()
    {
        return [
            [['title', 'special_right', 'edu_level', 'department','fio','status'], 'safe'],
            [['edu_document', 'country', 'category', 'user_id'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = TestingEntrant::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if(!\Yii::$app->user->can('dev')) {
            $query->andWhere(['user_id' => \Yii::$app->user->identity->getId()]);
        }

        $query->andFilterWhere([
            'user_id' => $this->user_id,
            'edu_document' => $this->edu_document,
            'category' => $this->category,
            'country' => $this->country,
            'status' => $this->status,
        ]);


        $query
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like','department' , $this->department])
            ->andFilterWhere(['like','special_right' , $this->special_right])
            ->andFilterWhere(['like','edu_level' , $this->edu_level]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictTestingEntrant())->attributeLabels();
    }
}