<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000105_add_column_statement extends Migration
{
    private function table() {
        return Statement::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), 'finance', $this->integer(1)->defaultValue(0));
    }

}
