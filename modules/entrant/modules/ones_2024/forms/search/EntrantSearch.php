<?php

namespace modules\entrant\modules\ones_2024\forms\search;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\modules\ones_2024\model\EntrantSS;
use yii\data\ActiveDataProvider;

class EntrantSearch extends EntrantSS
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant = null,$config = [])
    {   $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [[  "fio",
                "snils",
                "sex",
                'nationality',
                'email',
                'phone',
                'is_hostel'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

        if ($this->jobEntrant) {
            if ($this->jobEntrant->isCategoryFOK()) {
                $query->andWhere('quid IN (SELECT quid_profile FROM entrant_cg_app_2024_ss WHERE quid_cg_competitive IN (SELECT quid FROM cg_2024_ss WHERE faculty_id = '.$this->jobEntrant->faculty_id.'))' );
            }
            if (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
                $query->andWhere('quid IN (SELECT quid_profile FROM entrant_cg_app_2024_ss WHERE quid_cg_competitive IN (SELECT quid FROM cg_2024_ss WHERE faculty_id = '.$this->jobEntrant->category_id.'))' );
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
            'snils' => $this->snils,
            'is_hostel' => $this->is_hostel,
        ]);

        $query
            ->andFilterWhere(['like', 'fio', $this->fio])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'nationality', $this->nationality]);

        return $dataProvider;
    }

}
