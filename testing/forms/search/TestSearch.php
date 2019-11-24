<?php


namespace testing\forms\search;


use testing\helpers\TestHelper;
use testing\models\Test;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class TestSearch extends Model
{
    public $olimpic_id;

    public function rules()
    {
        return [
            [['olimpic_id', ], 'integer'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Test::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'olimpic_id' => $this->olimpic_id,
        ]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return Test::labels();
    }

    public function olympicList(): array
    {
        return TestHelper::testOlympicNameList();
    }

}