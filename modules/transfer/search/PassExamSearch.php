<?php
namespace modules\transfer\search;

use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\transfer\models\StatementTransfer;
use modules\transfer\readRepositories\StatementTransferReadRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PassExamSearch extends  Model
{
    public $user_id, $date_from, $edu_count, $date_to, $is_pass, $agree;
    protected $status;

    public function __construct($status, $config = [])
    {
        $this->status = $status;
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['edu_count', 'user_id', 'is_pass', 'agree'], 'integer'],
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
        $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readDataExamPass($this->status)->orderBy(['created_at' => SORT_DESC]);

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


        $query->andFilterWhere([
            'edu_count' => $this->edu_count,
            'is_pass' => $this->is_pass,
            'agree' => $this->agree,
            'user_id' => $this->user_id,
        ]);

        $query
            ->andFilterWhere(['>=', 'created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }

    /* @return  JobEntrant*/
    protected function getJobEntrant() {
        return \Yii::$app->user->identity->jobEntrant();
    }
}