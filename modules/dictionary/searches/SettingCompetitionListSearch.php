<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\SettingCompetitionList;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class SettingCompetitionListSearch extends Model
{
    public  $is_auto, $date_start, $date_end, $time_start, $time_end, $date_ignore;

    public function rules()
    {
        return [
            [['is_auto',], 'integer'],
            [['date_start', 'date_end', 'time_start', 'time_end', 'date_ignore'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = SettingCompetitionList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'is_auto' =>  $this->is_auto,
        ]);

        $query
            ->andFilterWhere(['like', 'date_ignore', $this->date_ignore])
            ->andFilterWhere(['like','time_start', $this->time_start])
            ->andFilterWhere(['like','time_end', $this->time_end])
            ->andFilterWhere(['like','date_start', $this->date_start])
            ->andFilterWhere(['like','date_end', $this->date_end]);

        return $dataProvider;
    }
}