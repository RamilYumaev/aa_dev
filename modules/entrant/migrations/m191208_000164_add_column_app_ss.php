<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000164_add_column_app_ss extends Migration
{
    private function table() {
        return "entrant_cg_app_2024_ss";
    }

    public function up()
    {
       $this->addColumn($this->table(), 'vuz_original', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
