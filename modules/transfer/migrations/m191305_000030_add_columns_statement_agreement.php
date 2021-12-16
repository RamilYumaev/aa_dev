<?php

namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000030_add_columns_statement_agreement extends Migration
{
    private function table() {
        return 'statement_agreement_contract_transfer_cg';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'number', $this->string()->null());
        $this->addColumn($this->table(), 'pdf_file', $this->string()->null());
    }
}
