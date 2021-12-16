<?php

namespace modules\transfer\migrations;

use \yii\db\Migration;

class m191305_000029_add_columns_LegalEntity extends Migration
{
    private function table()
    {
        return "legal_entity_transfer";
    }

    public function up()
    {
        $this->renameColumn($this->table(), "bank", "bik");
        $this->addColumn($this->table(), "p_c", $this->string("25")->notNull());
        $this->addColumn($this->table(), "k_c", $this->string("25")->notNull());
    }

    public function down()
    {
        $this->renameColumn($this->table(), "bik", "bank");
        $this->dropColumn($this->table(), 'p_c');
        $this->dropColumn($this->table(), 'k_c');
    }
}
