<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000044_add_columns_receipt extends Migration
{
    private function table() {
        return "receipt_contract_transfer";
    }

    public function up()
    {
        $this->addColumn($this->table(),'file_pdf', $this->integer()->defaultValue(0));
    }

    public function down()
    {

    }
}
