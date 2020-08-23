<?php

namespace modules\entrant\migrations;
use dictionary\models\DictCompetitiveGroup;
use modules\entrant\models\Statement;
use \yii\db\Migration;

class m191208_000099_add_ais_transfer_order extends Migration
{
    private function table() {
        return \modules\entrant\models\AisOrderTransfer::tableName();
    }

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable($this->table(), [
            'id' => $this->primaryKey(),
            'ais_cg' => $this->integer()->notNull(),
            'incoming_id' => $this->integer()->notNull(),
            'order_name' => $this->string()->notNull(),
            'order_date' => $this->date()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable($this->table());
    }
}
