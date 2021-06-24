<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\PreemptiveRight;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\entrant\models\StatementIndividualAchievements;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
use modules\entrant\services\StatementAgreementContractCgService;
use olympic\models\auth\Profiles;

class ProfileStatementCOZFOKReadRepository
{
    private $jobEntrant;
    private $isID;

    public function __construct(JobEntrant $jobEntrant = null, $isID = false)
    {
        if ($jobEntrant) {
            $this->jobEntrant = $jobEntrant;
        }
        $this->isID = $isID;
    }

    public function readData($type)
    {
        $query = $this->profileDefaultQuery();
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=profiles.user_id');
         if ($this->jobEntrant->isCategoryFOK()) {
             $specialUserArray = Statement::find()->select('user_id')
                 ->andWhere(['in','special_right',[
                     DictCompetitiveGroupHelper::SPECIAL_RIGHT]])->column();
            $query->andWhere(['not in', 'anketa.category_id', [
                 CategoryStruct::COMPATRIOT_COMPETITION, CategoryStruct::GOV_LINE_COMPETITION,
                 CategoryStruct::FOREIGNER_CONTRACT_COMPETITION,
                 CategoryStruct::WITHOUT_COMPETITION]])
                 ->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA])
                 ->andWhere(['not in', 'anketa.user_id', PreemptiveRight::find()
                     ->joinWith('otherDocument')->select("other_document.user_id")
                     ->indexBy("other_document.user_id")->column()]);
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
             $query->andWhere(['not in', 'anketa.user_id', $specialUserArray]);
        } elseif ($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        } elseif ($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id' => [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        } elseif (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
         }
        if ($type == AisReturnDataHelper::AIS_YES) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            return $query;
        } elseif ($type == AisReturnDataHelper::AIS_NO) {
            $query->andWhere(['not in', 'profiles.user_id', UserAis::find()->select('user_id')->column()]);
            return $query;
        } else {
            return $query;
        }
    }

    public function profileDefaultQuery()
    {
        return Profiles::find()->alias('profiles')
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
            ->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT])
            ->orderBy(['statement.user_id' => SORT_DESC])
            ->select(['statement.user_id', 'last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone'])
            ->distinct();
    }
}