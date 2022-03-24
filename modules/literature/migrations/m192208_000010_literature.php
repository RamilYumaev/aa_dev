<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000010_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'is_success', $this->boolean()->defaultValue(0));
        $this->addColumn($this->table(), 'code', $this->string(50)->null());
        $this->addColumn($this->table(), 'mark_end', $this->integer(3)->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
