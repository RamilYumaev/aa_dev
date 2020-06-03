<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use yii\data\ActiveDataProvider;

class StatementIAReadRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData() {
        $query = StatementIndividualAchievements::find()->statusNoDraft();

        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement_individual_achievements.user_id');

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement_individual_achievements.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }


        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement_individual_achievements.user_id');
            $query->andWhere(['anketa.university_choice'=> $this->jobEntrant->category_id]);
        }

        return $query;
    }
}