<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Statement;
use modules\entrant\models\StatementCg;
use modules\entrant\models\StatementConsentCg;
use \yii\db\Migration;

class m191208_000065_add_statement_rejection_cg extends Migration
{
    private function table() {
        return 'statement_rejection_cg';
    }

    public function up()
    {
        $this->alterColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
    }

}
