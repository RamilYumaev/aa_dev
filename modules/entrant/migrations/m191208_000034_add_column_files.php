<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000034_add_column_files extends Migration
{
    private function table() {
        return \modules\entrant\models\File::tableName();
    }

    public function up()
    {
       $this->addColumn($this->table(), "position", $this->integer()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'position');

    }
}
