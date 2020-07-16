<?php

namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use dictionary\models\DictCompetitiveGroup;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\Statement;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\UserCg;
use olympic\models\auth\Profiles;

class ProfilePotentialReadRepository
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

    public function readData()
    {
        $query = $this->profileDefaultQuery();
        if ($this->jobEntrant->isCategoryMPGU()) {
                $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                ->andWhere(['statement.status' => StatementHelper::STATUS_DRAFT]);
                $query->andWhere(["anketa.category_id"=>
                    [CategoryStruct::SPECIAL_RIGHT_COMPETITION, CategoryStruct::WITHOUT_COMPETITION]]);
        } elseif ($this->jobEntrant->isCategoryFOK()) {
            if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_STATEMENT_DRAFT) {
                $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                    ->andWhere(['statement.status' => StatementHelper::STATUS_DRAFT]);
                $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                    'statement.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                        DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                    ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                        CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
            } else if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_NO_STATEMENT) {
                $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM statement)');
                $query->innerJoin(UserCg::tableName(), 'user_cg.user_id=profiles.user_id');
                $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=user_cg.cg_id');
                $query->andWhere(['dict_competitive_group.faculty_id' => $this->jobEntrant->faculty_id,
                    'dict_competitive_group.edu_level' => [DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                        DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                    ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                        CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
            }
        } elseif ($this->jobEntrant->isCategoryCOZ()) {
            $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM user_cg)');
        } elseif ($this->jobEntrant->isCategoryGraduate()) {
            if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_STATEMENT_DRAFT) {
                $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')->andWhere(['statement.status' => StatementHelper::STATUS_DRAFT]);
                $query->andWhere(['statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
            } else if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_NO_STATEMENT) {
                $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM statement)');
                $query->innerJoin(UserCg::tableName(), 'user_cg.user_id=profiles.user_id');
                $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=user_cg.cg_id');
                $query->andWhere(['dict_competitive_group.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
            }
        } elseif ($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id' => [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
            if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_STATEMENT_DRAFT) {
                $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')->andWhere(['statement.status' => StatementHelper::STATUS_DRAFT]);;
            } else if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_NO_STATEMENT) {
                $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM statement)');
                $query->innerJoin(UserCg::tableName(), 'user_cg.user_id=profiles.user_id');
            }
        } elseif (in_array($this->jobEntrant->category_id, JobEntrantHelper::listCategoriesFilial())) {
            if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_STATEMENT_DRAFT) {
                $query->innerJoin(Statement::tableName(), 'statement.user_id=profiles.user_id')
                    ->andWhere(['statement.status' => StatementHelper::STATUS_DRAFT]);
                $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
            } else if ($this->isID == JobEntrantHelper::ENTRANT_POTENTIAL_NO_STATEMENT) {
                $query->andWhere('profiles.user_id NOT IN (SELECT user_id FROM statement)');
                $query->innerJoin(UserCg::tableName(), 'user_cg.user_id=profiles.user_id');
                $query->innerJoin(DictCompetitiveGroup::tableName(), 'dict_competitive_group.id=user_cg.cg_id');
                $query->andWhere(['dict_competitive_group.faculty_id' => $this->jobEntrant->category_id,]);
            }
        } elseif ($this->jobEntrant->isTPGU()) {
            $query->andWhere(['in', 'anketa.category_id', CategoryStruct::TPGU_PROJECT]);
        }

        return $query;

    }

    public function profileDefaultQuery()
    {
        return Profiles::find()->alias('profiles')
            ->innerJoin(Anketa::tableName(), 'anketa.user_id=profiles.user_id')
            ->orderBy(['anketa.user_id' => SORT_DESC])
            ->select(['anketa.user_id', 'last_name', 'first_name', 'patronymic', 'gender', 'country_id', 'region_id', 'phone'])
            ->distinct();
    }
}