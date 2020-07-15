<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000010_add_exam_result extends Migration
{
    private function table() {
        return 'exam_result';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'attempt_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'updated' => $this->timestamp()->null(),
            'result' => $this->text()->null(),
            'mark' => $this->integer(4),
            'tq_id' => 	$this->integer()->notNull(),
            'priority' =>$this->integer()->defaultValue(0),
        ], $tableOptions);

        $this->addPrimaryKey('exam_result-primary', $this->table(), 'attempt_id');

        $this->createIndex('{{%idx-exam_result-attempt_id}}', $this->table(), 'attempt_id');
        $this->addForeignKey('{{%fk-exam_result-attempt_id}}', $this->table(), 'attempt_id', 'exam_attempt', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_result-question_id}}', $this->table(), 'question_id');
        $this->addForeignKey('{{%fk-exam_result-question_id}}', $this->table(), 'question_id', 'exam_question', 'id',  'CASCADE', 'RESTRICT');

        $this->createIndex('{{%idx-exam_result-tq_id}}', $this->table(), 'tq_id');
        $this->addForeignKey('{{%fk-exam_result-tq_id}}', $this->table(), 'tq_id', 'exam_question_in_test', 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
