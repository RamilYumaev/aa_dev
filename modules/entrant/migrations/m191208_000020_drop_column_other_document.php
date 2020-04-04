<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000020_drop_column_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->dropColumn($this->table(), 'note');
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'note', $this->string()->null()->comment('Примечание'));
    }
}
