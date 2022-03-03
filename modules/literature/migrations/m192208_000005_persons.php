<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000005_persons extends Migration
{
    private function table() {
        return 'persons_literature';
    }

    public function up()
    {
       $this->addColumn($this->table(), 'agree_file', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
