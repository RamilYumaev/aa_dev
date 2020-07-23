<?php
namespace modules\exam\migrations;

use modules\exam\models\ExamStatement;
use \yii\db\Migration;

class m191333_000018_add_exam_violation extends Migration
{
    private function table() {
        return 'exam_violation';
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'exam_statement_id' => $this->integer()->notNull(),
            'datetime' => $this->dateTime(),
            'message' => $this->text()->null(),
        ], $tableOptions);

        $this->createIndex('{{%idx-exam_violation-exam_statement_id}}', $this->table(), 'exam_statement_id');
        $this->addForeignKey('{{%fk-exam_violation-exam_statement_id}}', $this->table(), 'exam_statement_id', ExamStatement::tableName(), 'id',  'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
