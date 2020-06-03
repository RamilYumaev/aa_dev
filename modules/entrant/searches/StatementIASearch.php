<?php
namespace modules\entrant\searches;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Anketa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementIAReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementIASearch extends  Model
{
    public $edu_level, $user_id, $date_from, $date_to;
    private $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['edu_level', 'user_id', ], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new StatementIAReadRepository($this->jobEntrant))->readData()->orderByCreatedAtDesc();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }


        $query->andFilterWhere([
            'statement_individual_achievements.edu_level' => $this->edu_level,
            'statement_individual_achievements.user_id' => $this->user_id,
        ]);

        $query
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }


}