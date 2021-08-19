<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000020_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_protocol', $this->boolean()->defaultValue(false));
    }
}
