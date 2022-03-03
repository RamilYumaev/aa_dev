<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000006_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'photo', $this->string()->null());
        $this->addColumn($this->table(), 'agree_file', $this->string()->null());
        $this->addColumn($this->table(), 'hash', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
