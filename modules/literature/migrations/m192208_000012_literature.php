<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000012_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'mark_end_last', $this->integer(3)->null());
        $this->addColumn($this->table(), 'status_last', $this->integer(1)->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
