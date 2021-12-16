<?php

namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000037_add_columns_statement_agreement extends Migration
{
    private function table() {
        return 'statement_agreement_contract_transfer_cg';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_mouth', $this->integer()->defaultValue(0));
    }
}
