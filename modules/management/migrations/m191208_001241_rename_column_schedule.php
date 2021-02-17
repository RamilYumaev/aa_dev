<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001241_rename_column_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $this->renameColumn($this->table(), "isEnable", "isBlocked");
    }

    public function down()
    {
        $this->renameColumn($this->table(), "isBlocked", "isEnable");
    }
}
