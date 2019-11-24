<?php

use \yii\db\Migration;

class m190124_110217_key_drop_in_table_test extends Migration
{
    private function table() {
        return \testing\models\Test::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("test_ibfk_1", $this->table());
}

    public function down()
    {
        echo '';
    }
}
