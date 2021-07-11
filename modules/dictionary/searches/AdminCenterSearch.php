<?php

namespace modules\dictionary\searches;


use modules\dictionary\models\AdminCenter;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class AdminCenterSearch extends Model
{
    public $job_entrant_id, $category;

    public function rules()
    {
        return [
            [['job_entrant_id', 'category'], 'integer'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = AdminCenter::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query
            ->andFilterWhere(['job_entrant_id' => $this->job_entrant_id,
                'category' => $this->category]);

        return $dataProvider;
    }

}