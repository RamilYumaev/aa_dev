<?php
namespace modules\exam\searches;

use dictionary\models\DictDiscipline;
use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\exam\helpers\ExamQuestionGroupHelper;
use modules\exam\models\ExamQuestion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamQuestionSearch extends Model
{
    public $discipline_id, $title, $type_id, $question_group_id;
    public $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['discipline_id', 'type_id', 'question_group_id'], 'integer'],
            ['title', 'safe'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = ExamQuestion::find();
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
            'type_id' => $this->type_id,
            'question_group_id' => $this->question_group_id,
        ]);

        $query
            ->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }

    public function filterDiscipline() {
        return $this->jobEntrant->isCategoryExam()
            ? DisciplineExaminerHelper::listDisciplineReserve($this->jobEntrant)
            : DisciplineExaminerHelper::listDiscipline();
    }

    public function filterQuestionGroup() {
        return $this->jobEntrant->isCategoryExam()
            ? ExamQuestionGroupHelper::listQuestionGroupIds($this->jobEntrant->examiner->disciplineColumn)
            : ExamQuestionGroupHelper::listQuestionGroup();
    }


}