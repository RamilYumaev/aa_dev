<?php

namespace modules\dictionary\searches;

use modules\dictionary\models\DictTestingEntrant;
use modules\dictionary\models\TestingEntrant;
use modules\dictionary\models\TestingEntrantDict;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TestingEntrantDictSearch extends Model
{
    public $id_testing_entrant;
    public $id_dict_testing_entrant;
    public $count_files;
    public $status;

    public function rules()
    {
        return [
            [['count_files', 'id_dict_testing_entrant', 'id_testing_entrant', 'status'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = TestingEntrantDict::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'count_files' => $this->count_files,
            'id_dict_testing_entrant' => $this->id_dict_testing_entrant,
            'id_testing_entrant' => $this->id_testing_entrant,
            'status' => $this->status
        ]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new TestingEntrantDict())->attributeLabels();
    }
}