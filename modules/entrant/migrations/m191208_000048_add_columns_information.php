<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000048_add_columns_information extends Migration
{
    private function table() {
        return \modules\entrant\models\AdditionalInformation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'chernobyl_status_id', $this->integer(1)->defaultValue(0)->comment("Чернобыль"));
        $this->addColumn($this->table(), 'mpgu_training_status_id', $this->integer(1)->defaultValue(0)->comment("Курсы МПГУ"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'chernobyl_status_id');
        $this->dropColumn($this->table(), 'mpgu_training_status_id');
    }
}
