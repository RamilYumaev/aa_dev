<?php

use \yii\db\Migration;

class m190124_110242_alter_columns_sending_template extends Migration
{
    private function table() {
        return \common\sending\models\DictSendingTemplate::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'type', $this->integer(1)->notNull()->defaultValue(1)->comment("1 - олимпиада, 2 - ДОД, 3 - мастер-классы"));
        $this->addColumn($this->table(), 'type_sending', $this->integer(1)->null()->comment("1 - приглашение, 2 - дипломы, 3 - приглашение после заочного тура"));
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'type_sending');
        $this->dropColumn($this->table(), 'type');
    }
}
