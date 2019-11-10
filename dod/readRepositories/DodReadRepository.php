<?php

namespace dod\readRepositories;

use dod\models\DateDod;
use dod\models\Dod;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class DodReadRepository
{
    public function count(): int
    {
        return Dod::find()->active()->count();
    }

    public function getAllByRange($offset, $limit): array
    {
        return Dod::find()->active()->orderBy(['id' => SORT_ASC])->limit($limit)->offset($offset)->all();
    }

    public function getAll()
    {
        $query = Dod::find()->alias('dod');
        $query->innerJoin(DateDod::tableName() . ' dod_date', 'dod_date.dod_id = dod.id');
        $query->orderBy(['dod_date.date_time' => SORT_DESC]);
        return $this->getProvider($query);
    }

    public function find($id): ?Dod
    {
        $model = Dod::find()
            ->alias('dod')
            ->innerJoin(DateDod::tableName() . ' dod_date', 'dod_date.dod_id = dod.id')
            ->orderBy(['dod_date.date_time' => SORT_DESC])
            ->where(['dod.id'=> $id])
            ->one();
        return  $model;
    }


    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}