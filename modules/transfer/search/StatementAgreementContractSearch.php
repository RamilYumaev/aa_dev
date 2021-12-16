<?php
namespace modules\transfer\search;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\readRepositories\ContractReadRepository;
use modules\transfer\models\StatementAgreementContractTransferCg;
use modules\transfer\models\StatementTransfer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementAgreementContractSearch extends  Model
{
    public $cg, $user_id, $date_from, $date_to, $number;
    public $status, $status_id;
    public $faculty;
    public $edulevel;
    private $jobEntrant;


    public function __construct($status, $faculty, $eduLevel,  $config = [])
    {
        $this->status = $status;
        $this->faculty = $faculty;
        $this->edulevel = $eduLevel;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id', 'cg', 'status_id'], 'integer'],
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
        $query = StatementAgreementContractTransferCg::find()->alias('contract')->joinWith('statementTransfer')->orderBy(['contract.created_at' => SORT_DESC]);;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->andWhere(['contract.status_id' => $this->status]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        if (!empty($this->user_id)) {
            $query->andWhere(['user_id' => $this->user_id]);
        }

        $query->andFilterWhere(['contract.status_id' => $this->status_id]);

        $query
            ->andFilterWhere(['like', 'number', $this->number])
            ->andFilterWhere(['>=', 'contract.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'contract.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'cg' => "Конкурсная группа",
            'user_id'=> "Студент",
            'created_at' => "Дата создания"
        ];
    }




}