<?php

namespace modules\dictionary\searches;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use modules\dictionary\models\DictRegion;

/**
 * DictRegionSearch represents the model behind the search form of `modules\dictionary\models\DictRegion`.
 */
class DictRegionSearch extends DictRegion
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ss_id'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = DictRegion::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ss_id' => $this->ss_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
