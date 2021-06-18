<?php


namespace modules\transfer\migrations;

use yii\db\Migration;

class m191305_000017_packet_document_user extends Migration
{
    private function table() {
        return 'packet_document_user';
    }

    public function up()
    {
       $this->addColumn($this->table(), 'number', $this->string(15)->defaultValue(''));
       $this->addColumn($this->table(), 'date', $this->date()->null());
       $this->addColumn($this->table(), 'authority', $this->string()->defaultValue(''));
       $this->addColumn($this->table(), 'note', $this->string()->defaultValue(''));
       $this->addColumn($this->table(), 'type', $this->integer()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
