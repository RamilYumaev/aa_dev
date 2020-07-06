<?php
namespace modules\entrant\readRepositories;
use dictionary\helpers\DictCompetitiveGroupHelper;
use modules\dictionary\helpers\JobEntrantHelper;
use modules\dictionary\models\JobEntrant;
use modules\entrant\models\ReceiptContract;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementAgreementContractCg;
use modules\entrant\models\StatementCg;

class ReceiptReadRepository
{
    private $jobEntrant;

    public function __construct(JobEntrant $jobEntrant = null)
    {
        if ($jobEntrant) {
            $this->jobEntrant = $jobEntrant;
        }
    }


    public function readData() {
        $query = ReceiptContract::find()->alias('receipt')->statusNoDraft('receipt.');
        $query->innerJoin(StatementAgreementContractCg::tableName() . ' contract', 'contract.id = receipt.contract_cg_id');
        $query->innerJoin(StatementCg::tableName() . ' cg', 'cg.id = contract.statement_cg');
        $query->innerJoin(Statement::tableName() . ' statement', 'statement.id = cg.statement_id');
        if ($this->jobEntrant->isAgreement()) {
            $query->andWhere(['statement.edu_level' => [
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_BACHELOR,
                DictCompetitiveGroupHelper::EDUCATION_LEVEL_MAGISTER]])
                ->andWhere(['not in', 'statement.faculty_id', JobEntrantHelper::listCategoriesFilial()]);
        }elseif ($this->jobEntrant->isCategoryGraduate()) {
            $query->andWhere(['statement.edu_level' => DictCompetitiveGroupHelper::EDUCATION_LEVEL_GRADUATE_SCHOOL]);
        }
        if(in_array($this->jobEntrant->category_id,JobEntrantHelper::listCategoriesFilial())) {
            $query->andWhere(['statement.faculty_id' => $this->jobEntrant->category_id]);
        }
        return $query;
    }
}