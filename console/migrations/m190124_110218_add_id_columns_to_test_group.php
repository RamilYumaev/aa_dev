<?php

use \yii\db\Migration;

class m190124_110218_add_id_columns_to_test_group extends Migration
{
    private function table() {
        return \testing\models\TestGroup::tableName();
    }

    public function up()
    {
        $this->dropForeignKey("test_group_ibfk_1", $this->table());
        $this->dropForeignKey("test_group_ibfk_2", $this->table());
        $this->dropPrimaryKey('test_id', $this->table());

        $this->addColumn($this->table(), 'id', $this->primaryKey()->first());
    }

    public function down()
    {
     echo "";
    }
}
