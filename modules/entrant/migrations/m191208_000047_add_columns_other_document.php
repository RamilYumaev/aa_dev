<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000047_add_columns_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'note', $this->string()->null()->comment("Примечание"));
        $this->addColumn($this->table(), 'type_note', $this->integer()->null()->comment("Тип примечание"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'note');
        $this->dropColumn($this->table(), 'type_note');
    }
}
