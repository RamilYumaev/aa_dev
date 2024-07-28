<?php

namespace modules\entrant\modules\ones_2024\forms\search;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\modules\ones_2024\model\CgSS;
use yii\data\ActiveDataProvider;

class CgSSSearch extends CgSS
{
    private $jobEntrant;


    public function __construct(JobEntrant $jobEntrant = null,$config = [])
    {   $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'education_level',
                'education_form', 'faculty_id',
                'speciality', 'profile', 'status',
                'type', 'kcp'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        if ($this->jobEntrant) {
            if ($this->jobEntrant->isCategoryFOK()) {
                $query->andWhere(['faculty_id' => $this->jobEntrant->faculty_id]);
            }

            if (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
                $query->andWhere(['faculty_id' => $this->jobEntrant->category_id]);
            }

            if($this->jobEntrant->isCategoryMPGU()) {
                $query->andWhere(['type' => ['Отдельная квота', 'Особая квота', 'Целевая квота']]);
            }
        }

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
            'faculty_id' => $this->faculty_id
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'education_level', $this->education_level])
            ->andFilterWhere(['like', 'education_form', $this->education_form])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'profile', $this->profile]);

        return $dataProvider;
    }

}
