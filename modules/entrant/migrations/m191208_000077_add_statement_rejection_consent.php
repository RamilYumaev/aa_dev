<?php

namespace modules\entrant\migrations;
use modules\entrant\models\StatementRejectionCgConsent;
use \yii\db\Migration;

class m191208_000077_add_statement_rejection_consent extends Migration
{
    private function table() {
        return StatementRejectionCgConsent::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'message', $this->string()->null());
    }

}
