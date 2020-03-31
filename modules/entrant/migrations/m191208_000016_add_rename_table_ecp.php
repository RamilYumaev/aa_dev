<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000016_add_rename_table_ecp extends Migration
{
    private function table() {
        return \modules\entrant\models\ECP::tableName();
    }

    public function up()
    {
      $this->addColumn($this->table(),'value', $this->integer()->notNull()->comment("Значение"));
      $this->renameTable($this->table(), "files");
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'value');
        $this->renameTable( "files", "ecp");
    }
}
