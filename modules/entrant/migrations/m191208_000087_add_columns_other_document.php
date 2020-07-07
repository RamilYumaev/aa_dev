<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000087_add_columns_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'without', $this->integer()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'without');
    }
}
