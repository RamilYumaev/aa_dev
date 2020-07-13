<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000002_add_exam_question_group extends Migration
{
    private function table() {
        return 'exam_question_group';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'exam_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull()
        ], $tableOptions);


        $this->createIndex('{{%idx-exam_question_group-exam_id}}', $this->table(), 'exam_id');
        $this->addForeignKey('{{%fk-exam_question_group-exam_id}}', $this->table(), 'exam_id', 'exam', 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
