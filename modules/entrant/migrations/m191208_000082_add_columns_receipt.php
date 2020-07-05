<?php
namespace modules\entrant\migrations;
use \yii\db\Migration;

class m191208_000082_add_columns_receipt extends Migration
{
    private function table() {
        return \modules\entrant\models\ReceiptContract::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(),'status_id', $this->integer()->defaultValue(0));
    }

    public function down()
    {

    }
}
