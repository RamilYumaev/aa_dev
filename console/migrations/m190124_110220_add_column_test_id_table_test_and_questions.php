<?php

use \yii\db\Migration;

class m190124_110220_add_column_test_id_table_test_and_questions extends Migration
{
    private function table() {
        return '{{%test_and_questions}}';
    }

    public function up()
    {
        $this->addColumn($this->table(),'test_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'test_id');
    }
}
