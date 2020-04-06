<?php
namespace modules\entrant\migrations;

use \yii\db\Migration;

class m191208_000023_add_columns_passport_data extends Migration
{
    private function table() {
        return \modules\entrant\models\PassportData::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), "main_status", $this->integer(1)->defaultValue(0)->comment("Основной документ"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), "main_status");
    }
}
