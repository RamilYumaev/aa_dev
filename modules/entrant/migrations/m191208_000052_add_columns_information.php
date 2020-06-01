<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000052_add_columns_information extends Migration
{
    private function table() {
        return \modules\entrant\models\AdditionalInformation::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'mark_spo', $this->float(3)->null()->comment("Средний балл аттестата"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'chernobyl_status_id');
    }
}
