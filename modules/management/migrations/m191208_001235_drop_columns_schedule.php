<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001235_drop_columns_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), "rate");
    }

    public function down()
    {
        $this->addColumn($this->table(), "rate", $this->integer(2)->notNull());
    }
}
