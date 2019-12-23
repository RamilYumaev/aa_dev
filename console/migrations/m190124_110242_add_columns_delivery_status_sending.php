<?php

use \yii\db\Migration;

class m190124_110242_add_columns_delivery_status_sending extends Migration
{
    private function table() {
        return \common\sending\models\SendingDeliveryStatus::tableName();
    }

    public function up()
    {
        $this->dropForeignKey('sending_delivery_status_ibfk_1',$this->table());
        $this->dropPrimaryKey('PRIMARY', $this->table());
        $this->addColumn($this->table(), 'id', $this->primaryKey()->first());
        $this->addColumn($this->table(), 'type', $this->integer(1)->notNull()->defaultValue(1)->comment("1 - олимпиада, 2 - ДОД, 3 - мастер-классы"));
        $this->addColumn($this->table(), 'value', $this->integer(11)->null());
        $this->addColumn($this->table(), 'type_sending', $this->integer(1)->null()->comment("1 - приглашение, 2 - дипломы"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'type');
        $this->dropColumn($this->table(), 'id');
        $this->dropColumn($this->table(), 'value');
        $this->dropColumn($this->table(), 'type_sending');
    }
}
