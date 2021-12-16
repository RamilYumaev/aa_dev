<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000045_add_columns_receipt extends Migration
{
    private function table() {
        return "receipt_contract_transfer";
    }

    public function up()
    {
        $this->dropColumn($this->table(),'period');
    }

    public function down()
    {

    }
}
