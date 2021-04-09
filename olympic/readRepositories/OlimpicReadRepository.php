<?php

namespace olympic\readRepositories;


use common\helpers\EduYearHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\models\Faculty;
use olympic\helpers\OlympicHelper;
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
        return $this->getProvider($this->queryOlympic());
    }

    protected function queryOlympic()
    {
        $query = Olympic::find()->alias('o');
        $query->innerJoin(OlimpicList::tableName() . ' ol', 'ol.olimpic_id = o.id');
        $query->select('o.name, o.id');
        $query->where(['o.status' => OlympicHelper::ACTIVE]);
        $query->andWhere(['ol.prefilling' => OlympicHelper::PREFILING_BAS]);
        $query->andWhere(['ol.is_volunteering' => false]);
        $query->andWhere(['ol.year' => EduYearHelper::eduYear() ]);
        $query->andWhere(['ol.prefilling' => false]);
        return $query;
    }

    protected function getSort($faculty, $formEdu, $isFilial)
    {
        $query = $this->queryOlympic();
        $query->innerJoin(Faculty::tableName() . ' fac', 'fac.id = ol.faculty_id');
        $query->andWhere(['ol.edu_level_olymp' => $formEdu]);
        $query->andWhere(['ol.faculty_id' => $faculty]);
        $query->andWhere(['fac.filial' => $isFilial]);
        return $query;
    }

    public function getAllMagistracy($faculty)
    {
        $query = $this->getSort($faculty, OlympicHelper::FOR_STUDENT, DictFacultyHelper::NO_FILIAL);
        return $this->getProvider($query);
    }

    public function getAllBaccalaureate($faculty)
    {
        $query = $this->getSort($faculty, OlympicHelper::levelOlympicBaccalaureateAll(), DictFacultyHelper::NO_FILIAL);
        return $this->getProvider($query);
    }

    public function getAllFilial($faculty)
    {
        $query = $this->getSort($faculty, OlympicHelper::levelOlympicAll(), DictFacultyHelper::YES_FILIAL);
        return $this->getProvider($query);
    }


    public function find($id): ?Olympic
    {
        return Olympic::find()
            ->alias('o')
            ->innerJoin(OlimpicList::tableName() . ' ol', 'ol.olimpic_id = o.id')
            ->where(['o.status' => OlympicHelper::ACTIVE, 'o.id'=> $id])
            ->andWhere(['ol.prefilling' => OlympicHelper::PREFILING_BAS])
            ->andWhere(['ol.is_volunteering' => false])
            ->andWhere(['ol.year' => EduYearHelper::eduYear() ])
            ->one();
    }

    public function findOldOlympic($id): ?OlimpicList
    {
        return OlimpicList::findOne(['id' =>$id, 'prefilling' => OlympicHelper::PREFILING_BAS]);
    }


    private function getProvider(ActiveQuery $query): ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }
}