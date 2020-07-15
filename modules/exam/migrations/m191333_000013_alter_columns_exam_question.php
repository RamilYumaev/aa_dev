<?php
namespace modules\exam\migrations;
use modules\exam\models\ExamQuestion;
use \yii\db\Migration;

class m191333_000013_alter_columns_exam_question extends Migration
{
    private function table() {
        return ExamQuestion::tableName();
    }

    public function up()
    {
        $this->dropForeignKey('{{%fk-exam_question-exam_id}}', $this->table());
        $this->dropIndex('{{%idx-exam_question-exam_id}}', $this->table());

        $this->renameColumn($this->table(), 'exam_id', 'discipline_id');

        $this->createIndex('{{%idx-exam_question-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-idx-exam_question-discipline_id}}', $this->table(), 'discipline_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');

    }

    public function down()
    {
    }
}
