<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000047_add_columns_receipt extends Migration
{
    private function table() {
        return "receipt_contract_transfer";
    }

    public function up()
    {
        $this->addColumn($this->table(),'message', $this->text());
    }

    public function down()
    {

    }
}
