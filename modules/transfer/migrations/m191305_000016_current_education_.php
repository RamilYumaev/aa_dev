<?php


namespace modules\transfer\migrations;


use yii\db\Migration;

class m191305_000016_current_education_ extends Migration
{
    private function table() {
        return 'current_education';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'specialization', $this->string()->defaultValue(''));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
