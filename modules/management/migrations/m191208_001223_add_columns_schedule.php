<?php
namespace modules\management\migrations;

use modules\management\models\Schedule;
use \yii\db\Migration;

class m191208_001223_add_columns_schedule extends Migration
{
    private function table() {
        return Schedule::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "rate", $this->integer(2)->notNull());
        $this->addColumn($this->table(), 'email', $this->string()->unique()->notNull());
        $this->addColumn($this->table(), "vacation", $this->boolean());
    }

    public function down()
    {
        $this->dropColumn($this->table(), "rate");
        $this->dropColumn($this->table(), "email");
        $this->dropColumn($this->table(), "vacation");
    }
}
