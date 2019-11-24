<?php

use \yii\db\Migration;

class m190124_110221_alter_mark_to_test_questions_table extends Migration
{
    private function table() {
        return \testing\models\TestQuestion::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'mark', $this->integer(11)->null());
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'mark', $this->integer(11)->notNull());
    }
}
