<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\helpers\DictCountryHelper;
use dictionary\helpers\DictFacultyHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\AisReturnDataHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\AdditionalInformation;
use modules\entrant\models\Anketa;
use modules\entrant\models\EntrantInWork;
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
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
            $query->andWhere('anketa.user_id NOT IN (SELECT user_id FROM statement WHERE special_right IN (1,2,4))');
        } elseif ($this->jobEntrant->isCategoryTarget()) {
            if ($this->isID == JobEntrantHelper::TARGET_BB) {
                $query->andWhere(['or', ['anketa.category_id' =>
                    CategoryStruct::COMPATRIOT_COMPETITION], ['special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]]);
            } else if ($this->isID == JobEntrantHelper::TASHKENT_BB) {
                $query->andWhere(['citizenship_id' => DictCountryHelper::TASHKENT_AGREEMENT])->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
            }else if ($this->isID == JobEntrantHelper::SPECIAL_QUOTA) {
                    $query->andWhere(['special_right' => DictCompetitiveGroupHelper::SPECIAL_QUOTA]);
            } else {
                $query->andWhere(['anketa.category_id' => [CategoryStruct::TARGET_COMPETITION,
                    CategoryStruct::COMPATRIOT_COMPETITION]])->orWhere([
                    'and', ['citizenship_id' => DictCountryHelper::TASHKENT_AGREEMENT],
                    ['>', 'statement.status', StatementHelper::STATUS_DRAFT], ['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                        CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]]);
            }
        } elseif ($this->jobEntrant->isCategoryGraduate()) {
            $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=profiles.user_id');
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION, CategoryStruct::TPGU_PROJECT]]);
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
            $query->joinWith('workUser')->andWhere(['is', EntrantInWork::tableName().'.`id`', null]);
            $query->andWhere('statement.user_id NOT IN (SELECT user_id FROM user_ais)');
            return $query;
        } elseif ($type == AisReturnDataHelper::IN_WORK) {
            $query->innerJoin(EntrantInWork::tableName(), EntrantInWork::tableName() . '.`user_id`=' . Profiles::tableName() . '.`user_id`');
            $query->andWhere('statement.user_id NOT IN (SELECT user_id FROM user_ais)');
            return $query;
        } elseif ($type == AisReturnDataHelper::IN_EPGU) {
            $query->innerJoin(AdditionalInformation::tableName(),AdditionalInformation::tableName() . '.`user_id`=' . Profiles::tableName() . '.`user_id`');
            $query->andWhere(['is_epgu'=> true]);
            return $query;
        } elseif ($type == AisReturnDataHelper::IN_TIME) {
            $query->innerJoin(AdditionalInformation::tableName(),AdditionalInformation::tableName() . '.`user_id`=' . Profiles::tableName() . '.`user_id`');
            $query->andWhere(['is_time'=> true]);
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