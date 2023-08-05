<?php

namespace modules\entrant\modules\ones\forms\search;

use modules\entrant\modules\ones\model\CompetitiveGroupOnes;
use yii\data\ActiveDataProvider;


class CompetitiveGroupSearch extends CompetitiveGroupOnes
{
    public function rules(): array
    {
        return [
            [['name', 'education_level',
                'education_form', 'department',
                'speciality', 'profile', 'status',
                'type_competitive', 'kcp', 'kcp_transfer'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'kcp' => $this->kcp,
            'kcp_transfer' => $this->kcp_transfer,
             'status' => $this->status
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'education_level', $this->education_level])
            ->andFilterWhere(['like', 'education_form', $this->education_form])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'type_competitive', $this->type_competitive])
            ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'profile', $this->profile]);

        return $dataProvider;
    }

}
