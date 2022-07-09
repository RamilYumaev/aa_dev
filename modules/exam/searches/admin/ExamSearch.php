<?php
namespace modules\exam\searches\admin;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Anketa;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\entrant\readRepositories\StatementIAReadRepository;
use modules\exam\forms\ExamForm;
use modules\exam\models\Exam;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamSearch extends Model
{
    public $discipline_id,  $date_from, $date_to, $time_exam;
    private  $status;

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['discipline_id', 'time_exam'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Exam::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'discipline_id' => $this->discipline_id,
            'time_exam' => $this->time_exam,
        ]);

        $query
            ->andFilterWhere(['>=', 'date_start', $this->date_from ?? null])
            ->andFilterWhere(['<=', 'date_end', $this->date_to ?? null]);

        return $dataProvider;
    }

    public function filterDiscipline() {
        return DisciplineExaminerHelper::listDisciplineAll();
    }


}