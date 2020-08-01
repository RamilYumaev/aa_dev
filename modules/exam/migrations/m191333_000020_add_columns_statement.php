<?php
namespace modules\exam\migrations;
use modules\exam\models\ExamQuestion;
use modules\exam\models\ExamStatement;
use \yii\db\Migration;

class m191333_000020_add_columns_statement extends Migration
{
    private function table() {
        return ExamStatement::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'time', $this->string(5)->null());
    }

    public function down()
    {
    }
}
