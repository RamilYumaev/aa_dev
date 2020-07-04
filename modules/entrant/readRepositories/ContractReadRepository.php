<?php
namespace modules\entrant\readRepositories;

use modules\entrant\models\StatementAgreementContractCg;

class ContractReadRepository
{
    public function readData() {
        $query = StatementAgreementContractCg::find();
        return $query;
    }
}