<?php
namespace modules\exam\searches;

use modules\dictionary\models\JobEntrant;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamStatement;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamStatementSearch extends Model
{
    public $exam_id, $entrant_user_id, $proctor_user_id, $date_from, $date_to, $type, $time;
    public $jobEntrant;

    public function __construct(JobEntrant $entrant = null, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['exam_id','entrant_user_id', 'proctor_user_id','type'], 'integer'],
            [['time'], 'safe'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = ExamStatement::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        if($this->jobEntrant && ($this->jobEntrant->category_id == 0 || $this->jobEntrant->isCategoryCOZ())) {
            $query->andWhere(['proctor_user_id'=> $this->jobEntrant->user_id]);
        }else if($this->jobEntrant && $this->jobEntrant->isCategoryTarget()) {
            $query->andWhere(['status'=> ExamStatementHelper::ERROR_RESERVE_STATUS]);
        }else{
            $query->andWhere(['proctor_user_id'=> null]);
        }

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'exam_id' => $this->exam_id,
            'type' => $this->type,
            'time' => $this->time,
            'entrant_user_id'=>$this->entrant_user_id,
            'proctor_user_id' => $this->proctor_user_id
        ]);

        $query
            ->andFilterWhere(['=', 'date', $this->date_from ??  null]);

        return $dataProvider;
    }



}