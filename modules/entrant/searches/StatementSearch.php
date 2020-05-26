<?php
namespace modules\entrant\searches;

use modules\entrant\models\Statement;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementSearch extends  Model
{
    public $faculty_id, $speciality_id, $edu_level, $special_right, $user_id, $date_from, $date_to;

    public function rules()
    {
        return [
            [['faculty_id', 'speciality_id', 'edu_level', 'special_right', 'user_id', ], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Statement::find()->statusNoDraft()->orderByCreatedAtDesc();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'faculty_id' => $this->faculty_id,
            'speciality_id' => $this->speciality_id,
            'edu_level' => $this->edu_level,
            'special_right'=> $this->special_right,
            'user_id' => $this->user_id,
        ]);


        $query
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }


}