<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictFacultyHelper;
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

class ProfileStatementReadRepository
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

        if ($this->jobEntrant->isCategoryMPGU()) {
            if ($this->isID == JobEntrantHelper::MPGU_ID) {
                $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
                $query->innerJoin(StatementIndividualAchievements::tableName(), 'statement_individual_achievements.user_id=profiles.user_id');
                $query->andWhere(['statement_individual_achievements.edu_level'
                => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                        DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
            } else if ($this->isID == JobEntrantHelper::MPGU_SR) {
                /*$query->andWhere(["in", "anketa.category_id",
                    [CategoryStruct::SPECIAL_RIGHT_COMPETITION, CategoryStruct::WITHOUT_COMPETITION]]);*/

                $query->andWhere(['or', ['special_right' => DictCompetitiveGroupHelper::SPECIAL_RIGHT],
                    ['anketa.category_id' => CategoryStruct::WITHOUT_COMPETITION]]);

//                $query->andWhere(['or',['and',["anketa.category_id"=> CategoryStruct::SPECIAL_RIGHT_COMPETITION],
//                    ['statement.special_right'=>DictCompetitiveGroupHelper::SPECIAL_RIGHT]],
//                    ["anketa.category_id"=>CategoryStruct::WITHOUT_COMPETITION]]);
            } else if ($this->isID == JobEntrantHelper::MPGU_PP) {
                $query->innerJoin(OtherDocument::tableName(), "other_document.user_id = anketa.user_id")
                    ->innerJoin(PreemptiveRight::tableName(), "preemptive_right.other_id= other_document.id");
            }
            $query->andWhere(['not in', 'faculty_id', DictFacultyHelper::FACULTY_FILIAL]);

        } elseif ($this->jobEntrant->isCategoryFOK()) {
            $specialUserArray = Statement::find()->select('user_id')
                ->andWhere(['in','special_right',[
                    DictCompetitiveGroupHelper::SPECIAL_RIGHT]])->column();
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
            $query->andWhere(['not in', 'anketa.user_id', $specialUserArray]);
        } elseif ($this->jobEntrant->isCategoryTarget()) {
            if ($this->isID == JobEntrantHelper::TARGET_BB) {
                $query->andWhere(['or', ['anketa.category_id' =>
                    CategoryStruct::COMPATRIOT_COMPETITION], ['special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]]);
            } else if ($this->isID == JobEntrantHelper::TASHKENT_BB) {
                $query->andWhere(['citizenship_id' => DictCountryHelper::TASHKENT_AGREEMENT]);
            } else {
                $query->andWhere(['anketa.category_id' => [CategoryStruct::TARGET_COMPETITION,
                    CategoryStruct::COMPATRIOT_COMPETITION]])->orWhere([
                    'and', ['citizenship_id' => DictCountryHelper::TASHKENT_AGREEMENT],
                    ['>', 'statement.status', StatementHelper::STATUS_DRAFT]]);
            }
        } elseif ($this->jobEntrant->isCategoryCOZ()) {
            $query->andWhere(['not in', 'anketa.category_id', [CategoryStruct::TARGET_COMPETITION,
                CategoryStruct::COMPATRIOT_COMPETITION, CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::SPECIAL_RIGHT_COMPETITION,
                CategoryStruct::WITHOUT_COMPETITION]])
                ->andWhere(['citizenship_id' => DictCountryHelper::RUSSIA])
                ->andWhere(['not in', 'anketa.user_id', PreemptiveRight::find()
                    ->joinWith('otherDocument')->select("other_document.user_id")
                    ->indexBy("other_document.user_id")->column()]);
        } elseif ($this->jobEntrant->isCategoryGraduate()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        } elseif ($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id' => [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        } elseif ($this->jobEntrant->isAgreement()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id')
                ->innerJoin(StatementCg::tableName(), 'statement_cg.statement_id=statement.id')
                ->innerJoin(StatementAgreementContractCg::tableName(),
                    'statement_agreement_contract_cg.statement_cg=statement_cg.id')
                ->andWhere(['>=', 'statement_agreement_contract_cg.status_id', StatementHelper::STATUS_DRAFT]);
        } elseif (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        } elseif ($this->jobEntrant->isTPGU()) {
            $query->andWhere(['in', 'anketa.category_id', CategoryStruct::TPGU_PROJECT]);
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
        // return Profiles::find()->alias('profiles')
        return Profiles::find()
            ->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
            ->andWhere(['>', 'statement.status', StatementHelper::STATUS_DRAFT])
            ->orderBy(['statement.user_id' => SORT_DESC])
            ->select(['statement.user_id', 'last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone'])
            ->distinct();
    }
}