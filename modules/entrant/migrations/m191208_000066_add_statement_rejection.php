<?php

namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000066_add_statement_rejection extends Migration
{
    private function table() {
        return 'statement_rejection';
    }

    public function up()
    {
        $this->alterColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
    }

}
