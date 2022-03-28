<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000011_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'code_two', $this->string(50)->null());
        $this->addColumn($this->table(), 'mark_end_two', $this->integer(3)->null());

        $this->addColumn($this->table(), 'code_three', $this->string(50)->null());
        $this->addColumn($this->table(), 'mark_end_three', $this->integer(3)->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
