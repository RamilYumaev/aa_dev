<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementRejectionCgSearch extends  Model
{
    public $faculty_id, $speciality_id, $edu_level, $special_right, $user_id, $date_from, $date_to;
    private $jobEntrant;
    private $status;

    public function __construct(JobEntrant $entrant, $status, $config = [])
    {
        $this->jobEntrant = $entrant;
        $this->status = $status;
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['faculty_id', 'speciality_id', 'edu_level', 'special_right', 'user_id', ], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @param  integer $limit
     * @return ActiveDataProvider
     */
    public function search(array $params, $limit = null): ActiveDataProvider
    {
        $query = (new StatementReadRepository($this->jobEntrant))->readData()
            ->innerJoin(StatementCg::tableName(), 'statement_cg.statement_id = statement.id')
            ->innerJoin(StatementRejectionCg::tableName(), 'statement_rejection_cg.statement_cg = statement_cg.id')
        ->orderByCreatedAtDesc();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' =>  $limit ?? 20,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if($this->status) {
            $query->andWhere(['statement_rejection_cg.status_id'=>  $this->status]);
        }

        return $dataProvider;
    }


}