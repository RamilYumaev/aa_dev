<?php

use \yii\db\Migration;

class m190124_110238_key_drop_in_table_diploma extends Migration
{
    private function table() {
        return \olympic\models\Diploma::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("diploma_ibfk_1", $this->table());
    }

    public function down()
    {
        echo '';
    }
}
