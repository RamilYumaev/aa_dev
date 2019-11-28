<?php

use \yii\db\Migration;

class m190124_110226_add_table_answer_cloze extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%answer_cloze}}', [
            'id' => $this->primaryKey(),
            'quest_prop_id' =>  $this->integer()->notNull(),
            'name' => $this->string(),
            'is_correct' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%answer_cloze}');
    }
}
