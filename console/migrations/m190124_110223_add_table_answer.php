<?php

use \yii\db\Migration;

class m190124_110223_add_table_answer extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%answer}}', [
            'id' => $this->primaryKey(),
            'quest_id' =>  $this->integer()->notNull(),
            'name' => $this->string(),
            'is_correct' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%answer}');
    }
}
