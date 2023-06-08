<?php

namespace modules\entrant\migrations;
use modules\entrant\models\LegalEntity;
use \yii\db\Migration;

class m191208_000147_add_columns_legal_entity extends Migration
{
    private function table() {
        return LegalEntity::tableName();
    }

    public function up()
    {
        $this->addColumn($this->table(), 'email', $this->string()->null());
    }
}
