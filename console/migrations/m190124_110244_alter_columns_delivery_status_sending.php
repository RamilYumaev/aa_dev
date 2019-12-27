<?php

use \yii\db\Migration;

class m190124_110244_alter_columns_delivery_status_sending extends Migration
{
    private function table() {
        return \common\sending\models\SendingDeliveryStatus::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'from_email', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'from_email');
    }
}
