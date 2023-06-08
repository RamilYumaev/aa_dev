<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000052_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_gia', $this->integer(1)->defaultValue(0));
    }
}
