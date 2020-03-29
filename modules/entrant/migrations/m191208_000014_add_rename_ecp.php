<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000014_add_rename_ecp extends Migration
{
    private function table() {
        return \modules\entrant\models\ECP::tableName();
    }

    public function up()
    {
      $this->renameColumn($this->table(), "file_name", "file_name_user");
      $this->addColumn($this->table(),'file_name_base', $this->string()->null()->comment("Файл"));
    }

    public function down()
    {
        $this->renameColumn($this->table(), "file_name_user", "file_name");
        $this->dropColumn($this->table(), 'file_name_base');

    }
}
