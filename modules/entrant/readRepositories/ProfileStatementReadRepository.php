<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use olympic\models\auth\Profiles;

class ProfileStatementReadRepository
{
    private $jobEntrant;



    public function __construct(JobEntrant $jobEntrant = null)
    {
        if($jobEntrant) {
         $this->jobEntrant = $jobEntrant;
        }
    }

    public function readData($type) {
        $query = $this->profileDefaultQuery();
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=profiles.user_id');
        if($this->jobEntrant->isCategoryMPGU()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->innerJoin(StatementIndividualAchievements::tableName(), 'statement_individual_achievements.user_id=profiles.user_id');
            $query->andWhere(['statement_individual_achievements.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        elseif($this->jobEntrant->isCategoryFOK()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        elseif($this->jobEntrant->isCategoryTarget()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        elseif($this->jobEntrant->isCategoryGraduate()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        elseif($this->jobEntrant->isCategoryUMS()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        elseif(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);;
        }

        if($type == AisReturnDataHelper::AIS_YES) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            return $query;
        }
        elseif($type == AisReturnDataHelper::AIS_NO) {
            $query->andWhere(['not in', 'profiles.user_id', UserAis::find()->select('user_id')->column()]);
            return $query;
        }
        else {
            return $query;
        }

    }

    public  function profileDefaultQuery() {
        return Profiles::find()->alias('profiles')
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                ->andWhere(['>','statement.status', StatementHelper::STATUS_DRAFT])
                ->orderBy(['statement.user_id'=> SORT_DESC])
                ->select([ 'statement.user_id', 'last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone'])
                ->distinct();
        }
}