<?php
namespace modules\dictionary\searches;

use modules\dictionary\models\RegisterCompetitionList;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class RegisterCompetitionListSearch extends Model
{
    public $ais_cg_id, $se_id, $status, $type_update, $number_update, $date, $time;

    public function rules()
    {
        return [
            [['status', 'type_update', 'number_update',  'se_id'], 'integer'],
            [['date', 'ais_cg_id','time'], 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = RegisterCompetitionList::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' =>  $this->status,
            'se_id' => $this->se_id,
            'type_update' => $this->type_update,
            'number_update' => $this->number_update,
        ]);

        $query
            ->andFilterWhere(['like', 'date', $this->date])
            ->andFilterWhere(['like', 'ais_cg_id', $this->ais_cg_id])
            ->andFilterWhere(['like', 'time', $this->time]);

        return $dataProvider;
    }
}