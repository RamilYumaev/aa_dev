<?php

namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000080_add_columns_statement_agreement extends Migration
{
    private function table() {
        return 'statement_agreement_contract_cg';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_mouth', $this->integer()->defaultValue(0));
    }
}
