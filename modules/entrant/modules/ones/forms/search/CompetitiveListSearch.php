<?php

namespace modules\entrant\modules\ones\forms\search;

use modules\entrant\modules\ones\model\CompetitiveList;
use yii\data\ActiveDataProvider;


class CompetitiveListSearch extends CompetitiveList
{
    public $cgId;
    public $idOrSnils;

    public function rules(): array
    {
        return [
            [['fio',
                'cg_id',
                'snils_or_id',
                'priority',
                'status',
                'sum_ball', 'mark_ai'], 'safe'],
        ];
    }

    public function __construct($cgId = null, $idOrSnils = null, $config = [])
    {
        $this->cgId = $cgId;
        $this->idOrSnils = $idOrSnils;
        parent::__construct($config);
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        if($this->cgId) {
            $query->andWhere(['cg_id' => $this->cgId]);
        }

        if($this->idOrSnils) {
            $query->andWhere(['snils_or_id' => $this->idOrSnils]);
        }

        $query->orderBy(['sum_ball' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => $this->status,
            'priority' => $this->priority,
            'sum_ball' => $this->sum_ball,
            'mark_ai,' => $this->mark_ai,
            'cg_id' => $this->cg_id,
        ]);

        $query
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'snils_or_id', $this->snils_or_id])

        ;

        return $dataProvider;
    }

}
