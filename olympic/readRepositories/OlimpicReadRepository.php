<?php

namespace olympic\readRepositories;


use olympic\models\OlimpicList;
use olympic\models\Olympic;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class OlimpicReadRepository
{
    public function count(): int
    {
        return Olympic::find()->active()->count();
    }

    public function getAllByRange($offset, $limit): array
    {
        return Olympic::find()->active()->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    public function getAll()
    {
        $query = Olympic::find()->alias('o');
        $query->innerJoin(OlimpicList::tableName() . ' ol', 'ol.olimpic_id = o.id');
        $query->orderBy(['ol.year' => SORT_DESC]);
        $query->select('o.name, o.id');
        $query->where(['o.status' => 0]);
        return $this->getProvider($query);
    }

    public function find($id): ?Olympic
    {
        return Olympic::find()
            ->alias('o')
            ->innerJoin(OlimpicList::tableName() . ' ol', 'ol.olimpic_id = o.id')
            ->where(['o.status' => 0, 'o.id'=> $id])
            ->one();
    }

    public function findOldOlympic($id): ?OlimpicList
    {
        return OlimpicList::findOne($id);
    }


    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}