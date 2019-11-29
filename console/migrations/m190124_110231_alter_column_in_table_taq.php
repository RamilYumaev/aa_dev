<?php

use \yii\db\Migration;

class m190124_110231_alter_column_in_table_taq extends Migration
{
    private function table() {
        return \testing\models\TestAndQuestions::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'question_id', $this->integer()->notNull());
        $this->alterColumn($this->table(), 'test_group_id', $this->integer()->notNull());
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'question_id', $this->integer()->null());
        $this->alterColumn($this->table(), 'test_group_id', $this->integer()->null());
    }
}
