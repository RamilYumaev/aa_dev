<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000033_add_column_files extends Migration
{
    private function table() {
        return \modules\entrant\models\File::tableName();
    }

    public function up()
    {
      $this->renameColumn($this->table(), "type", "model");
      $this->alterColumn($this->table(), 'model', $this->string()->notNull()->comment("Модель"));
      $this->renameColumn($this->table(), "value", "record_id");
    }

    public function down()
    {
        $this->renameColumn($this->table(), "file_name_user", "file_name");
        $this->dropColumn($this->table(), 'file_name_base');

    }
}
