<?php

namespace modules\entrant\migrations;
use modules\entrant\models\StatementRejectionCg;
use modules\entrant\models\StatementRejectionCgConsent;
use \yii\db\Migration;

class m191208_000077_add_statement_rejection_cg extends Migration
{
    private function table() {
        return StatementRejectionCg::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'message', $this->string()->null());
    }

}
