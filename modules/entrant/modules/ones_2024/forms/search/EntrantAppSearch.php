<?php

namespace modules\entrant\modules\ones_2024\forms\search;

use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\modules\ones_2024\model\EntrantCgAppSS;
use yii\data\ActiveDataProvider;

class EntrantAppSearch extends EntrantCgAppSS
{
    private $jobEntrant;
    private $id;

    private $different;

    public $snils;

    public $cgName;

    public $fio;

    public function __construct($id = null,JobEntrant $jobEntrant = null, $different = null,  $config = [])
    {   $this->jobEntrant = $jobEntrant;
        $this->id = $id;
        $this->different = $different;
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [[  'fio',
                'cgName',
                'snils',
                'priority_vuz',
                'priority_ss',
                'actual',
                'source',
                'status',
                'is_el_original',
                'is_paper_original',], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = self::find();

       if ($this->id) {
           $query->andWhere(['quid_cg_competitive' => $this->id]);
       }

       if ($this->different == 1) {
           $query->andWhere('priority_vuz <> priority_ss');
       }

        if ($this->different == 2) {
            $query->andWhere('priority_vuz IS NULL');
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
            'is_el_original' => $this->is_el_original,
            'is_paper_original' => $this->is_paper_original,
            'priority_ss' => $this->priority_ss,
            'priority_vuz' => $this->priority_vuz,
        ]);

        $query
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'status', $this->status]);

        if ($this->snils) {
            $query->joinWith(['entrant'])->andWhere(['snils' => $this->snils]);
        }

        if ($this->fio) {
            $query->joinWith(['entrant'])->andWhere(['like', 'fio', $this->fio]);
        }

        if ($this->jobEntrant) {
            if ($this->jobEntrant->isCategoryFOK()) {
                $query->joinWith(['cg'])->andWhere(['faculty_id' => $this->jobEntrant->faculty_id]);
            }

            if (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
                $query->joinWith(['cg'])->andWhere(['faculty_id' => $this->jobEntrant->category_id]);
            }
        }

        if ($this->cgName) {
            $query->joinWith(['cg'])->andWhere(['name' => $this->cgName]);
        }

        return $dataProvider;
    }

}
