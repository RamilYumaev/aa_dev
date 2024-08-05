<?php
namespace modules\entrant\migrations;

use yii\db\Migration;

class m191208_000166_add_column_entrant_ss extends Migration
{
    private function table() {
        return "entrant_2024_ss";
    }

    public function up()
    {
       $this->addColumn($this->table(), 'is_remote_original', $this->boolean()->defaultValue(0));
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
