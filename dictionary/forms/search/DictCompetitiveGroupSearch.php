<?php

namespace dictionary\forms\search;


use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class DictCompetitiveGroupSearch extends Model
{
    public $speciality_id,
        $id,
        $kcp,
        $edu_level,
        $passing_score,
        $competition_count,
        $special_right_id,
        $specialization_id,
        $faculty_id, $year,
        $financing_type_id,
        $education_form_id;

    public function rules()
    {
        return [
            [['speciality_id',
                'id',
                'kcp',
                'passing_score',
                'specialization_id',
                'edu_level',
                'special_right_id',
                'faculty_id', 'financing_type_id', 'education_form_id'], 'integer'],
            [['competition_count',],'number'],
            [['year'], 'string'],
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
            'id'=>$this->id,
            'edu_level'=>$this->edu_level,
            'passing_score'=> $this->passing_score,
            'special_right_id' => $this->special_right_id,
            'kcp'=>$this->kcp,
            'speciality_id' => $this->speciality_id,
            'specialization_id' => $this->specialization_id,
            'faculty_id' => $this->faculty_id,
            'financing_type_id'=> $this->financing_type_id,
            'education_form_id'=> $this->education_form_id,
        ]);

        $query->andFilterWhere(['like', 'year', $this->year]);
        $query->andFilterWhere(['like', 'competition_count', $this->competition_count]);

        return $dataProvider;
    }

    public function attributeLabels(): array
    {
        return DictCompetitiveGroup::labels();
    }

    public function specialityCodeList(): array
    {
        return DictSpecialityHelper::specialityNameAndCodeList();
    }

    public function financingTypeList()
    {
        return DictCompetitiveGroupHelper::getFinancingTypes();
    }

    public function facultyList(): array
    {
        return DictFacultyHelper::facultyList();
    }

    public function educationFormList()
    {
        return DictCompetitiveGroupHelper::getEduForms();
    }

    public function specializationList(): array
    {
        return DictSpecializationHelper::specializationList();
    }

}