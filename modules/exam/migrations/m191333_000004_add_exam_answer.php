<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000004_add_exam_answer extends Migration
{
    private function table() {
        return 'exam_answer';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'name' => $this->text()->null(),
            'is_correct' => $this->integer()->defaultValue(0),
            'answer_match'=> $this->text()->null()
        ], $tableOptions);


        $this->createIndex('{{%idx-exam_answer-question_id}}', $this->table(), 'question_id');
        $this->addForeignKey('{{%fk-exam_answer-question_id}}', $this->table(), 'question_id', 'exam_question', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
