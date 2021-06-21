<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use dictionary\models\Faculty;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AnketaHelper;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\UserCg;
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
        $query->innerJoin(UserCg::tableName(), 'user_cg.user_id=statement_individual_achievements.user_id');
        $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=user_cg.cg_id');
        $query->innerJoin(Faculty::tableName(), 'dict_faculty.id=dict_competitive_group.faculty_id');
        if($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
            ->andWhere(['dict_faculty.filial'=>false]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement_individual_achievements.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }


        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['dict_faculty.id'=> $this->jobEntrant->category_id]);
        }

        return $query;
    }
}