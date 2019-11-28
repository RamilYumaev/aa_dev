<?php

use \yii\db\Migration;

class  m190124_110225_add_table_question_proposition extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{question_proposition}}', [
            'id' => $this->primaryKey(),
            'quest_id' =>  $this->integer()->notNull(),
            'type'=> $this->integer(1)->notNull(),
            'name' => $this->string(),
            'is_start' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%question_proposition}');
    }
}
