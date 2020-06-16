<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\StatementRejectionCgConsent;
use modules\entrant\readRepositories\StatementReadConsentRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementConsentRejectionSearch extends  Model
{
    public  $cg, $user_id, $date_from, $date_to;

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
            [[ 'cg', 'user_id'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params, $limit=null ): ActiveDataProvider
    {
        $query = (new StatementReadConsentRepository($this->jobEntrant))->readData()
        ->innerJoin(StatementRejectionCgConsent::tableName(), 'statement_rejection_cg_consent.statement_cg_consent_id=consent.id');

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
            $query->andWhere(['statement_rejection_cg_consent.status_id'=>  $this->status]);
        }

        if (!empty($this->user_id)) {
            $query->andWhere(['statement.user_id' => $this->user_id]);
        }

        if (!empty($this->cg)) {
            $query->andWhere(['cg.cg_id' => $this->cg]);
        }

        $query
            ->andFilterWhere(['>=', 'consent.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'consent.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'user_id'=> "Абитуриент",
            'cg'=> "Конкурсная группа",
            'created_at' => "Дата создания"
        ];
    }




}