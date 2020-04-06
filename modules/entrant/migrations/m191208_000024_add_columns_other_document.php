<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000024_add_columns_other_document extends Migration
{
    private function table() {
        return \modules\entrant\models\OtherDocument::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'exemption_id', $this->integer(1)->null()->comment("Категория льготы"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'exemption_id');
    }
}
