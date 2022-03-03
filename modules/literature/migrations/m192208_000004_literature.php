<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000004_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->addColumn($this->table(), "date_arrival", $this->dateTime()->null());
        $this->addColumn($this->table(), "type_transport_arrival", $this->smallInteger(1)->null());
        $this->addColumn($this->table(), "place_arrival", $this->string()->null());
        $this->addColumn($this->table(), "number_arrival", $this->string(10)->null());
        $this->addColumn($this->table(), "date_departure", $this->dateTime()->null());
        $this->addColumn($this->table(), "type_transport_departure", $this->smallInteger(1)->null());
        $this->addColumn($this->table(), "place_departure", $this->string()->null());
        $this->addColumn($this->table(), "number_departure", $this->string(10)->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
