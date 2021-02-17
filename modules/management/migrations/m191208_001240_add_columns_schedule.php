<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001240_add_columns_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "isEnable", $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'isEnable');
    }
}
