<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000013_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->addColumn($this->table(), 'semester', $this->integer()->null());
        $this->dropColumn($this->table(), 'type');
    }
}
