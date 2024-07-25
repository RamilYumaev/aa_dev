<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000161_add_column_cg_ss extends Migration
{
    private function table() {
        return "cg_2024_ss";
    }

    public function up()
    {
       $this->addColumn($this->table(), 'status', $this->smallInteger()->defaultValue(0));
       $this->addColumn($this->table(), 'url', $this->text());
       $this->addColumn($this->table(), 'datetime_url', $this->dateTime()->null());
       $this->addColumn($this->table(), 'datetime_update_fok', $this->dateTime()->null());
       $this->addColumn($this->table(), 'datetime_view', $this->dateTime()->null());
       $this->addColumn($this->table(), 'file', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
