<?php

namespace modules\dictionary\searches;
use modules\dictionary\models\DictExaminer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictExaminerSearch extends Model
{
    public $fio;
    public $exams;

    public function rules()
    {
        return [
            ['fio', 'safe'],
            ['exams', 'integer']
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = DictExaminer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->exams) {
            $query->joinWith('disciplineExaminer')->andWhere(['discipline_id' => $this->exams]);
        }
        $query
            ->andFilterWhere(['like', 'fio', $this->fio]);


        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictExaminer())->attributeLabels();
    }

}