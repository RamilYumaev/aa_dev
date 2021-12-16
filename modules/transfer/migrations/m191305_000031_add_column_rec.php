<?php
namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000031_add_column_rec extends Migration
{
    private function table() {
        return 'receipt_contract_transfer';
    }

    public function up()
    {
        $this->addColumn($this->table(), "bank", $this->string()->null());
        $this->addColumn($this->table(), "pay_sum", $this->string()->null());
        $this->addColumn($this->table(), "date", $this->date()->null());
    }

    public function down()
    {

    }
}
