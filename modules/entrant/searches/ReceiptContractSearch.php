<?php
namespace modules\entrant\searches;

use modules\entrant\models\ReceiptContract;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\readRepositories\ReceiptReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ReceiptContractSearch extends  Model
{
    public $user_id, $number, $bank, $pay_sum, $date_from, $date_to;
    public $status, $status_id;


    public function __construct($status, $config = [])
    {
        $this->status = $status;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['user_id',  'status_id'], 'integer'],
            [['bank', 'pay_sum', 'number'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = (new ReceiptReadRepository())->readData()->alias('receipt')->statusNoDraft('receipt.');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($this->status) {
            $query->andWhere(['receipt.status_id' => $this->status]);
        }

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->innerJoin(StatementAgreementContractCg::tableName() . ' contract', 'contract.id = receipt.contract_cg_id');
        $query->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = contract.statement_cg');
        $query->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id');

        if (!empty($this->user_id)) {
            $query->andWhere(['statement.user_id' => $this->user_id]);
        }

        if (!empty($this->number)) {
            $query->andWhere(['like', 'number', $this->number]);
        }


        $query->andFilterWhere(['receipt.status_id' => $this->status_id])
            ->andFilterWhere(['like', 'receipt.pay_sum', $this->pay_sum])
            ->andFilterWhere(['like', 'receipt.bank', $this->bank])
            ->andFilterWhere(['>=', 'receipt.date', $this->date_from ? $this->date_from : null])
            ->andFilterWhere(['<=', 'receipt.date', $this->date_to ?  $this->date_to : null]);
        return $dataProvider;
    }

    public function attributeLabels()
    {
        return [
            'bank' => "Отделение банка",
            'pay_sum' => "Сумма платежа",
            'number' => "Номер договора",
            'user_id'=> "Абитуриент",
            'date' => "Дата платежа"
        ];
    }




}