<?php
namespace modules\exam\migrations;

use modules\exam\models\Exam;
use \yii\db\Migration;

class m191333_000011_alter_column_exam extends Migration
{
    private function table() {
        return Exam::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'time_end', $this->time()->notNull());
        $this->alterColumn($this->table(), 'time_end_reserve', $this->time()->null());

    }

    public function down()
    {
    }
}
