<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000005_add_exam_question_nested extends Migration
{
    private function table() {
        return 'exam_question_nested';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'question_id' => $this->integer()->notNull(),
            'type' => $this->integer()->null(),
            'name' => $this->text()->null(),
            'is_start' => $this->integer()->defaultValue(0),
        ], $tableOptions);


        $this->createIndex('{{%idx-exam_question_nested-question_id}}', $this->table(), 'question_id');
        $this->addForeignKey('{{%fk-exam_question_nested-question_id}}', $this->table(), 'question_id', 'exam_question', 'id',  'CASCADE', 'RESTRICT');


    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
