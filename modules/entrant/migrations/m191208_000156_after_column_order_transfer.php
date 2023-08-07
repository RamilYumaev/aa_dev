<?php

namespace modules\entrant\migrations;
use modules\entrant\models\LegalEntity;
use \yii\db\Migration;

class m191208_000156_after_column_order_transfer extends Migration
{
    private function table() {
        return "order_transfer_ones";
    }

    public function up()
    {
        $this->truncateTable($this->table());
        $this->alterColumn($this->table(), 'education_level', $this->string()->null());
        $this->alterColumn($this->table(), 'type_competitive', $this->string()->null());
        $this->alterColumn($this->table(), 'education_form', $this->string()->null());
    }
}
