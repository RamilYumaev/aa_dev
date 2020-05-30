<?php
namespace modules\entrant\searches;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class StatementSearch extends  Model
{
    public $faculty_id, $speciality_id, $edu_level, $special_right, $user_id, $date_from, $date_to;
    private $jobEntrant;

    public function __construct(JobEntrant $entrant, $config = [])
    {
        $this->jobEntrant = $entrant;
        parent::__construct($config);
    }


    public function rules()
    {
        return [
            [['faculty_id', 'speciality_id', 'edu_level', 'special_right', 'user_id', ], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }
    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Statement::find()->statusNoDraft()->orderByCreatedAtDesc();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement.user_id');

        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryTarget()) {
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        $query->andFilterWhere([
            'statement.faculty_id' => $this->faculty_id,
            'statement.speciality_id' => $this->speciality_id,
            'statement.edu_level' => $this->edu_level,
            'statement.special_right'=> $this->special_right,
            'statement.user_id' => $this->user_id,
        ]);


        $query
            ->andFilterWhere(['>=', 'statement.created_at', $this->date_from ? strtotime($this->date_from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'statement.created_at', $this->date_to ? strtotime($this->date_to . ' 23:59:59') : null]);

        return $dataProvider;
    }


}