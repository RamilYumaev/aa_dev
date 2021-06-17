<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000008_current_education_info_ extends Migration
{
    private function table() {
        return 'current_education_info';
    }

    public function up()
    {
        $this->dropTable($this->table());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
