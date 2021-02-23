<?php
namespace modules\management\migrations;

use modules\management\models\DictTask;
use \yii\db\Migration;

class m191208_001225_add_columns_dict_task extends Migration
{
    private function table() {
        return DictTask::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "color", $this->string(7)->notNull());
    }

    public function down()
    {
        $this->dropColumn($this->table(), "color");
    }
}
