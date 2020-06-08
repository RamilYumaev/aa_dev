<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000060_add_columns_statement_agreement_contract_cg_consent extends Migration
{
    private function table() {
        return 'statement_agreement_contract_cg';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type', $this->integer(1)->null());
        $this->addColumn($this->table(), 'record_id', $this->integer()->null());
    }

    public function down()
    {

    }
}
