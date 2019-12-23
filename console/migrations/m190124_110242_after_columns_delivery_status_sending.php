<?php

use \yii\db\Migration;

class m190124_110242_after_columns_delivery_status_sending extends Migration
{
    private function table() {
        return \common\sending\models\SendingDeliveryStatus::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'sending_id', $this->integer(11)->null());
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'sending_id', $this->integer(11)->notNull());
    }
}
