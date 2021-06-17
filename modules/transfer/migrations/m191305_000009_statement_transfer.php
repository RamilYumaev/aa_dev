<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000009_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->addColumn($this->table(), 'edu_count', $this->integer(1)->notNull());
        $this->addColumn($this->table(), 'course', $this->integer()->notNull());
        $this->addColumn($this->table(), 'cg_id', $this->integer()->notNull());
    }
}
