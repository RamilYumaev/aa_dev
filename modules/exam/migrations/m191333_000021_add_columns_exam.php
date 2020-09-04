<?php
namespace modules\exam\migrations;
use modules\exam\models\Exam;

use \yii\db\Migration;

class m191333_000021_add_columns_exam extends Migration
{
    private function table() {
        return Exam::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'src_bb', $this->string()->null());
    }

    public function down()
    {
    }
}
