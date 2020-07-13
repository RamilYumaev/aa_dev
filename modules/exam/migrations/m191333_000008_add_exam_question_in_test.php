<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000008_add_exam_question_in_test extends Migration
{
    private function table() {
        return 'exam_question_in_test';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'test_id' => $this->integer()->notNull(),
            'question_group_id' => $this->integer()->null(),
            'question_id' => $this->integer()->null(),
            'mark' => $this->integer(4)->null(),

        ], $tableOptions);


        $this->createIndex('{{%idx-exam_question_in_test-exam_id}}', $this->table(), 'test_id');
        $this->addForeignKey('{{%fk-exam_question_in_test-exam_id}}', $this->table(), 'test_id', 'exam_test', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_question_in_test-question_group_id}}', $this->table(), 'question_group_id');
        $this->addForeignKey('{{%fk-exam_question_in_test-question_group_id}}', $this->table(), 'question_group_id', 'exam_question_group', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_question_in_test-question_id}}', $this->table(), 'question_id');
        $this->addForeignKey('{{%fk-exam_question_in_test-question_id}}', $this->table(), 'question_id', 'exam_question', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
