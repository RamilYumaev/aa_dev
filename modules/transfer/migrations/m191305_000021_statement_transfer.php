<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000021_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'finance', $this->integer(1)->null());
        $this->addColumn($this->table(), 'success_exam', $this->integer(1)->defaultValue(0));
    }
}
