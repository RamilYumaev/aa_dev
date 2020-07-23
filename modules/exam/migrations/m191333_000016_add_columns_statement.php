<?php
namespace modules\exam\migrations;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamStatement;
use \yii\db\Migration;

class m191333_000016_add_columns_statement extends Migration
{
    private function table() {
        return ExamStatement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'date', $this->date()->null());
        $this->addColumn($this->table(), 'message', $this->string()->null());
        $this->addColumn($this->table(), 'type', $this->integer()->defaultValue(0));
    }

    public function down()
    {
    }
}
