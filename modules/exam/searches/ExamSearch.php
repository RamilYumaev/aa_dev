<?php
namespace modules\exam\searches;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictDiscipline;
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
    public $jobEntrant;
    private  $status;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
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

        if($this->jobEntrant->isCategoryExam()) {
            if($this->jobEntrant->category_id == JobEntrantHelper::EXAM) {
                $query->andWhere(['discipline_id'=> $this->jobEntrant->examiner->disciplineColumn]);
            }
            if($this->jobEntrant->category_id == JobEntrantHelper::TRANSFER) {
                $query->andWhere(['discipline_id'=> DictDiscipline::find()->select('id')
                    ->andWhere(['faculty_id' => $this->jobEntrant->faculty_id])->column()]);
            }
        }


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
        return $this->jobEntrant->isCategoryExam()
            ? DisciplineExaminerHelper::listDisciplineReserve($this->jobEntrant)
            : DisciplineExaminerHelper::listDisciplineAll();
    }
}
