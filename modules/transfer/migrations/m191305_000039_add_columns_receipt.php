<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000039_add_columns_receipt extends Migration
{
    private function table() {
        return "receipt_contract_transfer";
    }

    public function up()
    {
        $this->addColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
    }

    public function down()
    {

    }
}
