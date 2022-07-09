<?php
namespace modules\exam\searches\admin;

use modules\dictionary\models\JobEntrant;
use modules\exam\helpers\ExamStatementHelper;
use modules\exam\models\ExamStatement;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamStatementAdminSearch extends Model
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
        $query = ExamStatement::find()->andWhere(['status'=> [ExamStatementHelper::WALT_STATUS,
            ExamStatementHelper::SUCCESS_STATUS]])->andWhere(['is not','proctor_user_id', null ]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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