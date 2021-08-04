<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Agreement;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use modules\dictionary\models\JobEntrant;
class StatementReadConsentRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData() {
        $query = StatementConsentCg::find()->alias('consent')->statusNoDraft('consent.')->orderByCreatedAtDesc();

        $query->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = consent.statement_cg_id');
        $query->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id');

        $query->andWhere(['statement.status' => [StatementHelper::STATUS_ACCEPTED, StatementHelper::STATUS_NO_ACCEPTED]]);
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');

        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::SPECIAL_RIGHT_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
            $query->andWhere('anketa.user_id NOT IN (SELECT user_id FROM statement WHERE special_right IN (1,2))');
        }

        if ($this->jobEntrant->isTPGU()) {
            $query->andWhere(['anketa.category_id' => CategoryStruct::TPGU_PROJECT]);
        }

        if($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        if($this->jobEntrant->isCategoryMPGU()) {
                       $query->innerJoin(OtherDocument::tableName(), 'other_document.user_id=anketa.user_id');
            $query->andWhere(['or', ['is not', 'exemption_id', null], ['anketa.category_id' => CategoryStruct::WITHOUT_COMPETITION]])
                ->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
        }

        if($this->jobEntrant->isCategoryTarget()) {
            $query->innerJoin(Agreement::tableName(), 'agreement.user_id=anketa.user_id');
            $query->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        return $query->distinct();
    }

    public function readConsentData() {
        $query = StatementConsentCg::find()->alias('consent')->statusNoDraft('consent.')->orderByCreatedAtDesc();

        $query->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = consent.statement_cg_id');
        $query->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id');

        $query->andWhere(['statement.status' => [StatementHelper::STATUS_ACCEPTED, StatementHelper::STATUS_NO_ACCEPTED]]);
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');

        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'anketa.category_id', [CategoryStruct::GOV_LINE_COMPETITION,
                    CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        if ($this->jobEntrant->isTPGU()) {
            $query->andWhere(['anketa.category_id' => CategoryStruct::TPGU_PROJECT]);
        }

        if($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);
        }

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::WITHOUT_COMPETITION,
                CategoryStruct::SPECIAL_RIGHT_COMPETITION]])
                ->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        return $query->distinct();
    }
}