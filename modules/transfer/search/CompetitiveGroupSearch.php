<?php

namespace modules\transfer\search;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictFacultyHelper;
use dictionary\helpers\DictSpecialityHelper;
use dictionary\helpers\DictSpecializationHelper;
use dictionary\models\DictCompetitiveGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CompetitiveGroupSearch extends Model
{
    public $speciality_id,
        $edu_level,
        $specialization_id,
        $faculty_id,
        $year,
        $financing_type_id,
        $education_form_id;
    private $finance;

    public function __construct($finance, $config = [])
    {
        $this->finance = $finance;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['speciality_id',
                'specialization_id',
                'edu_level',
                'faculty_id',
                'financing_type_id',
                'education_form_id'], 'integer'],
            [['year'], 'string'],
        ];
    }

    public function getStatusFinance() {
        return $this->finance;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $currentYear = Date("Y");
        $lastYear = $currentYear - 1;
        $query = DictCompetitiveGroup::find()
            ->specialRight(null)
            ->andWhere(['not in', 'year', "$lastYear-$currentYear"])
            ->foreignerStatus(0)
            ->finance($this->getStatusFinance() ? DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT: [DictCompetitiveGroupHelper::FINANCING_TYPE_CONTRACT,
                DictCompetitiveGroupHelper::FINANCING_TYPE_BUDGET])
            ->tpgu(0)->orderBy(['year'=> SORT_ASC ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'edu_level'=>$this->edu_level,
            'speciality_id' => $this->speciality_id,
            'specialization_id' => $this->specialization_id,
            'faculty_id' => $this->faculty_id,
            'financing_type_id'=> $this->financing_type_id,
            'education_form_id'=> $this->education_form_id,
        ]);


        $query->andFilterWhere(['like', 'year', $this->year]);

        return $dataProvider;
    }

    public function getYears() {
        $years = [];
        $currentYear = Date("Y");
        for ($i = 1; $i < 6; $i++) {
            $year = $currentYear - $i;
            $old = $year-1;
            $years["$old-$year"] = $year;
        }
        return $years;
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