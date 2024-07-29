<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000165_add_column_cg_ss extends Migration
{
    private function table() {
        return "cg_2024_ss";
    }

    public function up()
    {
       $this->addColumn($this->table(), 'comment', $this->string(512)->null());
       $this->addColumn($this->table(), 'id_ones', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
