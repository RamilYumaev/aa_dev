<?php

namespace modules\transfer\migrations;
use \yii\db\Migration;

class m191305_000054_add_column_transfer_mpgu extends Migration
{
    private function table()
    {
        return 'transfer_mpgu';
    }

    public function up()
    {
        $this->addColumn($this->table(), 'data_order', $this->string()->null());
    }

    public function down()
    {
        $this->dropColumn($this->table(), 'data_order');
    }
}
