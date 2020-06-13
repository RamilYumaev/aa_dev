<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Agreement;
use \yii\db\Migration;

class m191208_000068_add_columns_agreement extends Migration
{
    private function table() {
        return Agreement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
        $this->addColumn($this->table(),'message', $this->text()->null());
    }

}
