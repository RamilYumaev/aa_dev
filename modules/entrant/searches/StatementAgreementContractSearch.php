<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\readRepositories\ContractReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementAgreementContractSearch extends  Model
{
    public $faculty_id,  $cg, $user_id, $date_from, $date_to, $number;
    public $status, $status_id;
    private $jobEntrant;


    public function __construct($status, JobEntrant $jobEntrant,   $config = [])
    {
        $this->status = $status;
        $this->jobEntrant = $jobEntrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'faculty_id', 'cg', 'status_id'], 'integer'],
            [['number'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new ContractReadRepository($this->jobEntrant))->readData()->orderByCreatedAtDesc();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($this->status) {
            $query->andWhere(['consent.status_id' => $this->status]);
        }

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->user_id)) {
            $query->andWhere(['statement.user_id' => $this->user_id]);
        }

        if (!empty($this->cg)) {
            $query->andWhere(['cg.cg_id' => $this->cg]);
        }

        if (!empty($this->faculty_id)) {
            $query->andWhere(['statement.faculty_id' => $this->faculty_id]);
        }

        $query->andFilterWhere(['consent.status_id' => $this->status_id]);

        $query
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['>=', 'consent.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'consent.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'faculty_id' => "Факультет",
             'cg' => "Конкурсная группа",
            'user_id'=> "Абитуриент",
            'created_at' => "Дата создания"
        ];
    }




}