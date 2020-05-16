<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000042_add_column_files extends Migration
{
    private function table() {
        return \modules\entrant\models\File::tableName();
    }

    public function up()
    {
       $this->truncateTable($this->table());
       $this->addColumn($this->table(), "created_at", $this->integer()->notNull());
       $this->addColumn($this->table(), "updated_at", $this->integer()->notNull());
       $this->addColumn($this->table(), "status", $this->integer(1)->defaultValue(0));
        $this->addColumn($this->table(), "message", $this->string()->null());

    }

    public function down()
    {

    }
}
