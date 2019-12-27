<?php

use \yii\db\Migration;

class m190124_110242_alter_columns_sending extends Migration
{
    private function table() {
        return \common\sending\models\Sending::tableName();
    }

    public function up()
    {
        $this->alterColumn($this->table(), 'sending_category_id', $this->integer(11)->null());
        $this->alterColumn($this->table(), 'template_id', $this->integer(11)->null());
        $this->addColumn($this->table(), 'type_sending', $this->integer(1)->null()->comment("1 - приглашение, 2 - дипломы"));
    }

    public function down()
    {
        $this->alterColumn($this->table(), 'sending_category_id', $this->integer(11)->notNull());
        $this->alterColumn($this->table(), 'template_id', $this->integer(11)->notNull());
        $this->dropColumn($this->table(), 'type_sending');
    }
}
