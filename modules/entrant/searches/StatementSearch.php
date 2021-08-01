<?php
namespace modules\entrant\searches;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementSearch extends  Model
{
    public $faculty_id, $speciality_id, $edu_level, $special_right, $user_id,
        $form_category,
        $finance,
        $date_from,
        $date_to;
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
            [['faculty_id', 'speciality_id', 'edu_level', 'special_right', 'user_id', 'form_category', 'finance' ], 'integer'],
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
        $query = (new StatementReadRepository($this->jobEntrant))->readData()->orderByCreatedAtDesc();

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
            $query->andWhere(['statement.status'=>  $this->status]);
        }

        $query->andFilterWhere([
            'statement.faculty_id' => $this->faculty_id,
            'statement.speciality_id' => $this->speciality_id,
            'statement.edu_level' => $this->edu_level,
            'statement.special_right'=> $this->special_right,
            'statement.user_id' => $this->user_id,
            'statement.form_category' => $this->form_category,
            'statement.finance'=> $this->finance,
        ]);

        $query
            ->andFilterWhere(['>=', 'statement.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'statement.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }


}