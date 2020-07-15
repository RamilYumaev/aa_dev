<?php
namespace modules\exam\migrations;

use \yii\db\Migration;

class m191333_000014_add_exam_result extends Migration
{
    private function table() {
        return 'exam_result';
    }

    public function up()
    {
        $this->dropPrimaryKey('exam_result-primary', $this->table());
        $this->addPrimaryKey('exam_result-primary', $this->table(), ['attempt_id', 'question_id']);

    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
