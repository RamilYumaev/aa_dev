<?php

namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000077_add_statement_rejection extends Migration
{
    private function table() {
        return 'statement_rejection';
    }

    public function up()
    {
        $this->addColumn($this->table(),'message', $this->string()->null());
    }

}
