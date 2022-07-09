<?php
namespace modules\exam\searches\admin;

use modules\dictionary\helpers\DisciplineExaminerHelper;
use modules\exam\helpers\ExamQuestionGroupHelper;
use modules\exam\models\ExamQuestion;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExamQuestionSearch extends Model
{
    public $discipline_id, $title, $type_id, $question_group_id;

    public function __construct( $config = [])
    {
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
        return DisciplineExaminerHelper::listDisciplineAll();
    }

    public function filterQuestionGroup() {
            return ExamQuestionGroupHelper::listQuestionGroup();
    }
}