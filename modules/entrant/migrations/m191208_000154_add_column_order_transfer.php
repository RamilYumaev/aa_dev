<?php

namespace modules\entrant\migrations;
use modules\entrant\models\LegalEntity;
use \yii\db\Migration;

class m191208_000154_add_column_order_transfer extends Migration
{
    private function table() {
        return "order_transfer_ones";
    }

    public function up()
    {
        $this->addColumn($this->table(), 'education_form', $this->json());
    }
}
