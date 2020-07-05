<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000075_add_column_rec extends Migration
{
    private function table() {
        return \modules\entrant\models\ReceiptContract::tableName();
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
