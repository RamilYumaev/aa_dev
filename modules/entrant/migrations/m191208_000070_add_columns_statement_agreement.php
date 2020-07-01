<?php

namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000070_add_columns_statement_agreement extends Migration
{
    private function table() {
        return 'statement_agreement_contract_cg';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'number', $this->string()->null());
        $this->addColumn($this->table(), 'pdf_file', $this->string()->null());
    }
}
