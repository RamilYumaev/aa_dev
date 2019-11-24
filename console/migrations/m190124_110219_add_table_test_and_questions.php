<?php

use \yii\db\Migration;

class m190124_110219_add_table_test_and_questions extends Migration
{
    private function table() {
        return '{{%test_and_questions}}';
    }

    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'test_group_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
