<?php

namespace modules\entrant\migrations;
use modules\entrant\models\Address;
use \yii\db\Migration;

class m191208_000144_add_columns_address extends Migration
{
    private function table() {
        return Address::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'region_id', $this->integer()->null());
    }
}
