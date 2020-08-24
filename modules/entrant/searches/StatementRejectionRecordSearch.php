<?php
namespace modules\entrant\searches;

use modules\dictionary\models\JobEntrant;
use modules\entrant\models\StatementRejectionRecord;
use modules\entrant\readRepositories\StatementReadConsentRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementRejectionRecordSearch extends  Model
{
    public  $cg, $user_id, $date_from, $date_to, $status;
    private $statusId;


    public function __construct($status, $config = [])
    {
        $this->statusId = $status;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [[ 'cg', 'user_id', 'status'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params ): ActiveDataProvider
    {
        $query = StatementRejectionRecord::find()->orderBy(['created_at'=>SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['status'=>  $this->status]);

        if ($this->statusId) {
            $query->andWhere(['status'=>  $this->statusId]);
        }

        if (!empty($this->user_id)) {
            $query->andWhere(['user_id' => $this->user_id]);
        }
        if (!empty($this->cg)) {
            $query->andWhere(['cg_id' => $this->cg]);
        }

        $query
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }






}