<?php
namespace modules\entrant\readRepositories;

use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\entrant\helpers\CategoryStruct;
use modules\entrant\helpers\StatementHelper;
use modules\entrant\models\Anketa;
use modules\entrant\models\OtherDocument;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\UserAis;
use modules\dictionary\models\JobEntrant;
class StatementCgReadRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant)
    {
        $this->jobEntrant = $jobEntrant;
    }

    public function readData() {
        $query = StatementCg::find();
        $query->innerJoin(Statement::tableName(), 'statement.id = statement_cg.statement_id');
        $query->innerJoin(UserAis::tableName(), 'user_ais.user_id=statement.user_id');
        $query->innerJoin(Anketa::tableName(), 'anketa.user_id=statement.user_id');
        if($this->jobEntrant->isCategoryFOK()) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->faculty_id,
                'statement.edu_level' =>[DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                    DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]]);
        }

        if($this->jobEntrant->isCategoryTarget()) {
            $query->andWhere([
                'statement.special_right' => DictCompetitiveGroupHelper::TARGET_PLACE]);
        }

        if($this->jobEntrant->isCategoryUMS()) {
            $query->andWhere(['anketa.category_id'=> [CategoryStruct::GOV_LINE_COMPETITION,
                CategoryStruct::FOREIGNER_CONTRACT_COMPETITION]]);

        }

        if($this->jobEntrant->isCategoryMPGU()) {
            $query->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
            $query->innerJoin(OtherDocument::tableName(), 'other_document.user_id=anketa.user_id');
            $query->andWhere(['or', ['is not', 'exemption_id', null], ['anketa.category_id' => CategoryStruct::WITHOUT_COMPETITION]]);
        }

        if($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere([
                'statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }

        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }

        return $query;
    }
}