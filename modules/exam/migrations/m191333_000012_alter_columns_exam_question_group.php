<?php
namespace modules\exam\migrations;

use modules\exam\models\ExamQuestionGroup;
use \yii\db\Migration;

class m191333_000012_alter_columns_exam_question_group extends Migration
{
    private function table() {
        return ExamQuestionGroup::tableName();
    }

    public function up()
    {
        $this->dropForeignKey('{{%fk-exam_question_group-exam_id}}', $this->table());
        $this->dropIndex('{{%idx-exam_question_group-exam_id}}', $this->table());

        $this->renameColumn($this->table(), 'exam_id', 'discipline_id');

        $this->createIndex('{{%idx-exam_question_group-discipline_id}}', $this->table(), 'discipline_id');
        $this->addForeignKey('{{%fk-idx-exam_question_group-discipline_id}}', $this->table(), 'discipline_id', \dictionary\models\DictDiscipline::tableName(), 'id',  'RESTRICT', 'RESTRICT');

    }

    public function down()
    {
    }
}
