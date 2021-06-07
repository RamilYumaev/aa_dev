<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000007_add_column_current_education_info_ extends Migration
{
    private function table() {
        return 'current_education_info';
    }

    public function up()
    {
        $this->addColumn($this->table(),'speciality', $this->string()->notNull());
    }
}
