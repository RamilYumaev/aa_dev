<?php
namespace modules\literature\migrations;

use \yii\db\Migration;

class m192208_000009_literature extends Migration
{
    private function table() {
        return 'literature_olympic';
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'size', $this->string(10)->null());
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
