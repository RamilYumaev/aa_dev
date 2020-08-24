<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000101_add_columns_statement_rejection_cg extends Migration
{
    private function table() {
        return \modules\entrant\models\StatementRejectionRecord::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'pdf_file', $this->string()->null());
    }
}
