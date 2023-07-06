<?php
namespace modules\transfer\search;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementReadRepository;
use modules\transfer\models\PassExam;
use modules\transfer\models\StatementTransfer;
use modules\transfer\models\TransferMpgu;
use modules\transfer\readRepositories\StatementTransferReadRepository;
use Mpdf\Tag\Tr;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementSearch extends  Model
{
    public $user_id, $date_from, $edu_count, $date_to;
    public $type;
    public $finance;
    public $faculty_id;
    public $success_exam;
    private $status;
    private $exam;
    public function __construct($status, $exam = null,  $config = [])
    {
        $this->status = $status;
        $this->exam = $exam;
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['edu_count', 'user_id', 'type', 'success_exam', 'finance'], 'integer'],
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
        if(!is_null($this->exam)) {
            $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readDataExamPass(PassExam::SUCCESS)
                ->andWhere([PassExam::tableName().'.success_exam'=> $this->exam]);
        } else {
            $query = (new StatementTransferReadRepository($this->getJobEntrant()))->readData()->orderBy(['created_at' => SORT_DESC]);
        }

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

        if(!is_null($this->status)) {
            $query->andWhere(['status'=>  $this->status]);
        }

        if($this->type) {
            if(!is_null($this->exam)) {
                $query->joinWith('statement.transferMpgu')->andWhere([TransferMpgu::tableName() . '.type' => $this->type,]);
            }else {
                $query->joinWith('transferMpgu')->andWhere([TransferMpgu::tableName() . '.type' => $this->type,]);
            }
        }

        $query->andFilterWhere([
            'edu_count' => $this->edu_count,
            'user_id' => $this->user_id,
            'finance'=>  $this->finance,
            'success_exam'=> $this->success_exam,
            'faculty_id' => $this->faculty_id,
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