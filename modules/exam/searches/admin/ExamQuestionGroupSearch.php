<?php
namespace modules\exam\searches\admin;


use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\dictionary\models\JobEntrant;
use modules\exam\models\ExamQuestionGroup;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamQuestionGroupSearch extends Model
{
    public $discipline_id,  $name;
    public $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['discipline_id'], 'integer'],
            ['name', 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = ExamQuestionGroup::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if($this->jobEntrant->isCategoryExam()) {
            $query->andWhere(['discipline_id'=> $this->jobEntrant->examiner->disciplineColumn]);
        }

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'discipline_id' => $this->discipline_id,
        ]);

        $query
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

    public function filterDiscipline() {
        return $this->jobEntrant->isCategoryExam()
            ? DisciplineExaminerHelper::listDisciplineReserve($this->jobEntrant)
            : DisciplineExaminerHelper::listDiscipline();
    }
}