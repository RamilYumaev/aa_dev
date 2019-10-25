<?php

namespace olympic\forms\dictionary\search;


use olympic\helpers\dictionary\DictFacultyHelper;
use olympic\helpers\dictionary\DictSpecialityHelper;
use olympic\helpers\dictionary\DictSpecializationHelper;
use olympic\models\dictionary\DictCompetitiveGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictCompetitiveGroupSearch extends Model
{
    public $speciality_id, $specialization_id, $faculty_id;

    public function rules()
    {
        return [
            [['speciality_id', 'specialization_id', 'faculty_id'], 'integer'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = DictCompetitiveGroup::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'speciality_id' => $this->speciality_id,
            'specialization_id' => $this->specialization_id,
            'faculty_id'=> $this->faculty_id
        ]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictCompetitiveGroup::labels();
    }

    public function  specialityCodeList(): array
    {
        return DictSpecialityHelper::specialityCodeList();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function specializationList(): array
    {
        return DictSpecializationHelper::specializationList();
    }

}