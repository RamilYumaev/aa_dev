<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000007_persons extends Migration
{
    private function table() {
        return 'persons_literature';
    }

    public function up()
    {
        $this->addColumn($this->table(),  'series', $this->string()->null());
        $this->addColumn($this->table(),  'number', $this->string()->null());
        $this->addColumn($this->table(),  'date_issue', $this->date()->null());
        $this->addColumn($this->table(),  'authority', $this->string()->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
