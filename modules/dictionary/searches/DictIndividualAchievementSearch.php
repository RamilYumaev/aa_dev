<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\DictIndividualAchievement;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictIndividualAchievementSearch extends  Model
{
    public $name, $name_short,  $year,  $category_id, $mark;

    public function rules()
    {
        return [
            [['category_id', 'mark' ], 'integer'],
            [['name','year','name_short'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictIndividualAchievement::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'mark' => $this->mark,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'name_short', $this->name_short])
            ->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return (new DictIndividualAchievement())->attributeLabels();
    }

}