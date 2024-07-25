<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000162_add_column_app_ss extends Migration
{
    private function table() {
        return "entrant_cg_app_2024_ss";
    }

    public function up()
    {
       $this->addColumn($this->table(), 'datetime', $this->dateTime()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
