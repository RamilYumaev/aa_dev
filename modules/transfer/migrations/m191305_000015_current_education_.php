<?php


namespace modules\transfer\migrations;


use yii\db\Migration;

class m191305_000015_current_education_ extends Migration
{
    private function table() {
        return 'current_education';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'school_name', $this->string()->notNull());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
