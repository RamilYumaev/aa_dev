<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000006_add_exam_answer_nested extends Migration
{
    private function table() {
        return 'exam_answer_nested';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'question_nested_id' => $this->integer()->notNull(),
            'name' => $this->string()->null(),
            'is_correct' => $this->integer()->defaultValue(0),
        ], $tableOptions);


        $this->createIndex('{{%idx-exam_answer_nested-question_nested_id}}', $this->table(), 'question_nested_id');
        $this->addForeignKey('{{%fk-exam_answer_nested-question_nested_id}}', $this->table(), 'question_nested_id', 'exam_question_nested', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
