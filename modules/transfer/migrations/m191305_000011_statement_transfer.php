<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000011_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->alterColumn($this->table(), 'edu_count', $this->integer(1)->notNull());
        $this->alterColumn($this->table(), 'course', $this->integer()->null());
        $this->alterColumn($this->table(), 'cg_id', $this->integer()->null());
    }
}
