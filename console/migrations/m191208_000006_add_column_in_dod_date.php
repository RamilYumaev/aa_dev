<?php

use \yii\db\Migration;

class m191208_000006_add_column_in_dod_date extends Migration
{
    private function table() {
        return \dod\models\DateDod::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'text', $this->text()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'text');
    }
}
