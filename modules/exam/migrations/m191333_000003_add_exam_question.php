<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000003_add_exam_question extends Migration
{
    private function table() {
        return 'exam_question';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'question_group_id' => $this->integer()->null(),
            'exam_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'file_type_id' => $this->integer()->null(),
        ], $tableOptions);


        $this->createIndex('{{%idx-exam_question-question_group_id}}', $this->table(), 'question_group_id');
        $this->addForeignKey('{{%fk-exam_question-question_group_id}}', $this->table(), 'question_group_id', 'exam_question_group', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_question-exam_id}}', $this->table(), 'exam_id');
        $this->addForeignKey('{{%fk-exam_question-exam_id}}', $this->table(), 'exam_id', 'exam', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
