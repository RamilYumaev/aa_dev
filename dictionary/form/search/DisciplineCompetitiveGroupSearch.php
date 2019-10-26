<?php


namespace dictionary\forms\search;


use dictionary\models\DisciplineCompetitiveGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DisciplineCompetitiveGroupSearch extends Model
{

    public $discipline_id, $competitive_group_id, $priority;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['discipline_id', 'competitive_group_id', 'priority'], 'integer'],
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
        $query = DisciplineCompetitiveGroup::find();

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
            'discipline_id' => $this->discipline_id,
            'competitive_group_id' => $this->competitive_group_id,
            'priority' => $this->priority,
        ]);

        return $dataProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return DisciplineCompetitiveGroup::labels();
    }

}