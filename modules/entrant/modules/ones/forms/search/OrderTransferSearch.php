<?php

namespace modules\entrant\modules\ones\forms\search;

use modules\entrant\modules\ones\model\OrderTransferOnes;
use yii\data\ActiveDataProvider;


class OrderTransferSearch extends OrderTransferOnes
{
    public function rules(): array
    {
        return [
            [[ 'education_level',
                'department', 'education_form',
                'type_competitive',], 'safe'],
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


        $query
            ->andFilterWhere(['like', 'education_level', $this->education_level])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'education_form', $this->education_form])
            ->andFilterWhere(['like', 'type_competitive', $this->type_competitive])

        ;

        return $dataProvider;
    }

}
