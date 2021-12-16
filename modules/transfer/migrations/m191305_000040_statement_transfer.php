<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000040_statement_transfer extends Migration
{
    private function table() {
        return 'statement_transfer';
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'success_exam');
    }
}
