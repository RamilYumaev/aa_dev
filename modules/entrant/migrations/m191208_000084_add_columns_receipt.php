<?php
namespace modules\entrant\migrations;
use modules\entrant\models\StatementAgreementContractCg;
use \yii\db\Migration;

class m191208_000084_add_columns_receipt extends Migration
{
    private function table() {
        return \modules\entrant\models\ReceiptContract::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'message', $this->string()->null());
        $this->addColumn(StatementAgreementContractCg::tableName(),'message', $this->string()->null());
    }

    public function down()
    {

    }
}
