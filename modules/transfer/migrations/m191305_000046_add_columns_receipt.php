<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000046_add_columns_receipt extends Migration
{
    private function table() {
        return "receipt_contract_transfer";
    }

    public function up()
    {
        $this->alterColumn($this->table(),'file_pdf', $this->string()->null());
    }

    public function down()
    {

    }
}
